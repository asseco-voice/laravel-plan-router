<p align="center"><a href="https://see.asseco.com" target="_blank"><img src="https://github.com/asseco-voice/art/blob/main/evil_logo.png" width="500"></a></p>

# Laravel plan router

This package is an extension of [inbox package](https://github.com/asseco-voice/laravel-inbox). 
Its main purpose is to define a model for routing incoming communication by matching certain 
regex patterns and executing callbacks when pattern is matched.  

*Use case:* you have an endpoint for receiving emails which you need to parse based on some parameter,
having one callback executed if incoming email comes from ``.*@gmail.com`` domain, other from `.*@yahoo.com`,
and handling special cases when subject of email has ``VIP`` in it. 

## Installation

Install the package through composer. It is automatically registered as a Laravel service provider, so no additional actions are required.

``composer require asseco-voice/laravel-plan-router``

## Terminology

### Match

Attribute to match regex against.

**Example**: 
- For email, this can be: *from, to, cc, bcc, subject*
- For SMS, this can be: *from, to, body*

### Plan

A user-friendly name for set of regex matches which must be matched in order for the plan to be hit.
``Plan`` is thus a many-to-many relation with `Match` for which you can define the actual
regex in a pivot table.

`priority` if two plans for two different skill groups are a hit at the same time, higher priority plan
has greater precedence, and if hit, all other callbacks which might be a match won't be hit.

``match_either`` - functions as an OR/AND gate. If set to `true`, having more than one match defined,
only one has to be matched for a plan to be hit. If set to ``false``, all matches need to be hit in order
for that particular plan to be hit.  

Example: you can have a "VIP Gmail clients" plan which can hit when both ``to: .*@gmail.com`` and `subject: VIP` 
clauses are hit.

### Skill group

Entity representing a group of people to which the plan must be assigned so that you can have one group
handling i.e. "VIP Gmail clients" and other group handling "Regular clients".

If you don't have a valid use case for many skill groups, you can use a single default group.

## Setup

Steps for package setup:

1. Define a controller method which is responsible for inbound communication (i.e. receive email)
and call ``receive()`` method from `InboxService` facade.
    
    If you are using package for email, you can use already prepared request and method:
    
    ```php
    public function receive(EmailRequest $request)
    {
        InboxService::receive($request->email());
    }
    ```
   
1. If you are using any other (non-email) form of communication, be sure to feed the `receive()` method 
with a class implementing ``Message`` interface. It is a simple interface which needs to define two methods:

    - ``isValid()`` to check whether incoming message is valid
    - ``getMatchedValues($matchBy)`` which based on the attributes you defined in `Match` table should parse
    the message accordingly. I.e. if ``Match`` has `recipient` field to match by, when someone hits 
    `getMatchedValues('recipient')`, your method needs to know how to return it from an inbound message. 

1. Have the model which represents communication messages in your system (i.e. ``Message``, `Mail`...)
implement a ``CanPlan`` interface. 
1. Define methods from that interface. Callback will execute if a plan is hit, and fallback will execute 
if no plan was hit.
1. Bind the model to the interface in your ``AppServiceProvider@boot()``

    ```php
    $this->app->bind(CanPlan::class, Message::class);
    ```

1. Publish migrations with ``artisan vendor:publish --tag=asseco-plan-router`` and modify `skill_groups`
table if necessary, other are best left intact. 
1. Run ``artisan migrate`` and run `PlanRouterPackageSeeder` seeder if you want to see some dummy data as well.
