<p align="center"><a href="https://see.asseco.com" target="_blank"><img src="https://github.com/asseco-voice/art/blob/main/evil_logo.png" width="500"></a></p>

# Laravel plan router

This package is an extension of [inbox package](https://github.com/asseco-voice/laravel-inbox). 
Its main purpose is to provide the ability to define multiple ``Plans`` with certain regex rules,
and upon providing some input return the matched ``Plan``.

I.e. you may have one `Plan` matching `*@gmail` addresses, other one matching `*@yahoo.com` addresses.
Provided the input, package will return either first or second plan, depending on the actual address 
provided.

## Installation

Install the package through composer. It is automatically registered as a Laravel service provider, 
so no additional actions are required.

``composer require asseco-voice/laravel-plan-router``

## Terminology

### Rule

Attribute to match regex against.

**Example**: 
- For email, this can be: *from, to, cc, bcc, subject*
- For SMS, this can be: *from, to, body*

### Plan

A user-friendly name for set of regex matches which must be matched in order for the plan to be hit.
``Plan`` is a many-to-many relation with `Rule` for which you can define the actual
regex in a pivot table.

I.e.
```
Plan 1 -> from     *@gmail.com
       -> subject  *VIP*

Plan 2 -> from     *@yahoo.com
```

`priority` if two plans are a hit at the same time, higher priority plan
has greater precedence, and if hit, all other callbacks which might be a match won't be hit.

``match_either`` - functions as an OR/AND gate. If set to `true`, having more than one match defined,
only one has to be matched for a plan to be hit. If set to ``false``, all matches need to be hit in order
for that particular plan to be hit.  

## Setup

To set up the package: 

1. Run migrations with ``artisan migrate``
1. Run (or include in your `DatabaseSeeder`) ``PlanRouterPackageSeeder`` to seed dummy data. 
For production, only `RuleSeeder` will be run as it is the only one mandatory for package to function.
It defines what can your **raw** payload match by.
1. For any custom requirements, provide your own ``RuleSeeder`` instead of one from the package.

## Usage

Call `InboxService::match()` in a place in your code where you're planning to receive the messages.
Function takes a single parameter which is a class implementing a ``CanMatch`` interface, so be sure
to dedicate a class which will parse your **raw** input and which you can then forward to the method.

Details about ``CanMatch`` implementation can be seen in 
[original package documentation](https://github.com/asseco-voice/laravel-inbox).
This will return a matched ``Plan`` in case of a successful match, or `null` in case of no 
match.

Example:

```php
public function __invoke(ReceiveEmailRequest $request)
{
    // email() is some arbitrary method in form request 
    // returning a CanMatch instance from given request data.
    $canMatchInstance = $request->email(); 

    $matchedPlan = InboxService::match($canMatchInstance);

    return response('success');
}

```

### Plan - model values

You can provide a set of ``attribute => value`` values for each plan which would be responsible
for changing the attributes of a saved model (check the `plan_model_values` table). The model
must use a ``HasPlanValues`` trait.

For example, having a ``Message`` model with attributes `title` and `description`, and two `Plans`
with following values:

```
ID  plan_id attribute       value

1   1       title           New title
2   2       description     Modify this
```

Meaning that ``Plan`` 1 will modify title, and `Plan` 2 will modify description. 

Now, when a hit happens, you can apply these modifications. 

```php

$message = Message::create([
    'title'         => 'some title',
    'description'   => 'some description',
]);

// Let's say Plan 2 was hit
$matchedPlan = InboxService::match($canMatchInstance);

$message->applyPlanValues($matchedPlan);

dd(
    $message->title,      // Will dump "some title" as Plan 2 doesn't have title in plan_model_values.
    $message->description // Will dump "Modify this" because of Plan 2 hit. 
);
```

You can also set the ``attribute`` in the DB to be a relation name. It is a prerequisite
a relation with that name exists on a model. In that case, the relation will be 
updated instead of the actual model attribute. 

I.e. if ``Message`` belongs to a `Folder`, and has a `folder(): BelongsTo` method, you 
can define a ``Plan`` model values as such:

```
ID  plan_id attribute       value

1   1       folder          1
```

# Extending the package

Publishing the configuration will enable you to change package models as
well as controlling how migrations behave. If extending the model, make sure
you're extending the original model in your implementation.
