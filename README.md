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

In order to use the package, there are several steps to be followed:

1. Run migrations with ``artisan migrate``
1. If you have a need to modify migrations, you can publish them with
``artisan vendor:publish --tag=asseco-plan-router`` and modify `skill_groups`
table if necessary, other are best left intact. Be sure to set the ``runs_migrations``
in the published config file to ``false`` in that case.
1. Run (or include in your `DatabaseSeeder`) ``PlanRouterPackageSeeder`` to seed dummy data. 
For production, only `MatchSeeder` will be ran as it is the only one mandatory for package to function.
It defines what can your **raw** payload match by.
1. Call `InboxService::receive()` in a place in your code where you're planning to receive the messages.
Function takes a single parameter which is a class implementing a ``CanPlan`` interface, so be sure
to dedicate a class which will parse your **raw** input and which you can then forward to the method.
    
    Interface consists of several methods:
    
    - ``isValid()`` - checks if a message is valid.
    
    - ``getMatchedValues($matchBy)`` which based on the attributes you defined in `matches` table should parse
    the message so that it knows where to fetch the certain attribute from.
        
        Example, having *from* and *to* in `matches` table:
            
        ```php
        public function getMatchedValues(string $matchBy): array
        {
            switch ($matchBy) {
                case 'from':
                    return $this->parseFrom();
                case 'to':
                    return $this->parseTo();
                default:
                    return [];
            }
        }
        ```
    
    - `planCallback()` which is a method you should implement which will execute when a plan is matched.
    
    - `planFallback()` which is a method you should implement which will execute when no plan is matched.

1. If you are using ``SkillGroups`` from the package, you may add `Skillable` trait to your model to
expose the relationship.
