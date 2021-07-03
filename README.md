# Corvus PHP Skeleton with Auth

Hi, I created this boilerplat for my own needs but prefer to share with other products. My aim in this project is to allow devellper to start the project as fast as could be. 

## Why I developed this project?
First I usually prefer to use a framework. However those days the frameworks are updating the versions  so quickly. It's annoying me to chase the versions etc. Indeed frameworks help me to start a project. However after a few years later, maintaining of a project is blocking me. So I created this boilerplat. I'm using this boilerplate mostly in internal projects and the need of the projects are limited. 

## Packages that I used 
I try to reduce usage of the packages. Here my aim is not to maintance the application after I created. I used Doctrine for database operations. I added Twig hence sometimes I need to install frontend and backend in a single host. I always plan to use a frontend framework. For that reason, Authentication is based on json token. I used PHP-DI to manage dependecies, it's powerful and well-developed to use at least next five years without changing the skeleton. 

## Quick start
Everything is in Docker, all you need is download the codes, run composer and run docker compose.

## What's Next
I'll add new features if I think that it must be in a starter project. Currently I'll add role and permission system. 