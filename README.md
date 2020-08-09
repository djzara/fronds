# Fronds

## A micro CMS

### Build Statuses

Core and UI? [![Build Status](https://travis-ci.com/desertrat-io/fronds.svg?branch=master)](https://travis-ci.com/desertrat-io/fronds)

Can you use me? [![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/desertrat-io/fronds/blob/master/LICENSE.txt)

How is our testing doing? [![Coverage Status](https://coveralls.io/repos/github/djzara/fronds/badge.svg?branch=master)](https://coveralls.io/github/djzara/fronds?branch=master)

## History

Fronds started as a desire to make a quick little site management app for my artist friends who needed their own brochure
sites, but with a tiny bit of dynamic functionality. While thinking about how to build this in an easy to setup way
so I could just set it up and go, giving them their own themes, minimal dynamic behavior, and the ability to brand
themselves.

While thinking about how I wanted to build this out, I knew I wanted a little bit of extensibility in how it was built
so that if one of my friends needed something new, I could build it out with ease. 

So, I had the idea to add some extremely simple admin options, and dynamic features. A static site generator wouldn't
really give me what I needed in terms of front end abilities, and a regular CMS is just overkill. Sure, some CMSs do
very minimal amounts of things out of the box, but are nearly useless without a lot of work and needing modules or
plugins just to make new pages or menus, never mind theming using weird directory conventions (I'm looking at you
dr...errr) and difficulty in actually display content the way you'd think it would be displayed.

At the same time, I realized that my PHP framework of choice, Laravel, was perfect for this sort of thing. Blade
is very powerful, and the templates can be compiled dynamically if needed, not to mention easily extended. Creating
a way to build plugins wouldn't be too hard either. Front end code? Why care? Make it easy and let a builder use
anything they want. Vue would be officially supported, but it would be pretty simple to switch to React or Angular if
you so desire. KISS that front end long and hard. Themes? Why spend so much time writing CSS that you get frustrated
and grab a wor...errr theme from some other site so that it looks just like everyone else? This was meant for artists 
after all.

Minimalism is a concept I take to heart, and while Laravel may seem like overkill, the ability to actually provide that
minimalism is easier. Create just enough to do everything the average user might want to create a brochure site
with some extra bells and whistles, but don't add too much. Allow for plugins to be created, but ensure those plugins
also do a minimal amount of work. Use a framework that people actually know and can build from instead of the convoluted
systems that we see major use in today. Adopt better security practices via this minimal system so that vulnerabilities
aren't just posted all over the web to be taken advantage of.  Reuse code and components as much as possible to keep
the code base minimal. Ideally, the biggest feature of all would be the extensive unit testing to make it all work.

## Experiment

This system is an experiment to see what the boundaries are when it comes to minimalism and extensibility at the
same time. I want plugins to exist and to be able to be used, but I don't want to require third party everything
just to create the basics. A junior developer should be able to use this system in no time at all and not face a learning
curve that nopes you right on out. While a community is nice, the idea and framework should be minimal enough that a 
community isn't a crutch to do anything. Documentation should be concise and comprehensive, but not difficult to read or
boring such that things are easily missed or skipped.

## Don't rebuild the wheel

Keep in mind, just 200 years ago wheels were made of wood and would by no means work with the automobiles of today,
and so we changed how they worked, we didn't reinvent them. Why not do the same with software...like we already do?

At the end of the day, I'm doing this for fun. If you'd like to leave an idea or two in the issues section, please go
right ahead.

### Notes

CONTRIBUTION and other items coming.

