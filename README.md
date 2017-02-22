# PHP Mini Framework

I wrote this because I got tired of the massive PHP frameworks that are slow 
as dogs and are just too much.  Even the Sinatra knockoffs are just too 
much.  Sometimes you just want to be able to get something simple done
without all the fluff.  Sometimes you use PHP because it is so ubiquitous,
despite not wanting to.



## How It Works

Clone the project. There is a `mini` directory in it.  This is the 
framework, all less than 4kB and 150 LOC of it.  Add another directory 
for your domain logic classes; perhaps it is called `stuff` and 
contains a file `stuff.php` with a couple handy methods in a `Stuff` 
class.  Create an `index.php` file in the root of the project that looks something like this:


```
<?php

    include 'mini/mini.php';

    Mini::init(['stuff']);
    Mini::register(['stuff' => new Stuff()]);    

    Mini::get('route')->register('/stuff\/(\d+)$/i', function($stuff_id) {
        $content = Mini::get('stuff')->getStuffList($stuff_id);
        Mini::get('response')->setType('json')
                             ->setContent($content);
    });

    Mini::get('response')->flush();
```

Yep, that's it.  Include `mini.php`. Initialize your domain logic, which is 
done by directory.  Every file in the directory is autoloaded, all the 
classes are available.  Register the `Stuff` class with the framework; this 
is sort of like having dependency injection but way easier for small projects.
Get the `Route` class and register a route using a regular expression and
a closure to encapsulate the execution.  Use the `Response` class to formulate
the response after processing your `stuff`.  At the end just flush the response.
You will want to add more entries to the `typemap.php` file if you want to 
support more types of content. You can put parameters in a `.env` file, .ini 
style.  There is an accessor for the `.env` contents, like there is for everything,
that is _not_ the terrible PHP global design pattern seen elsewhere. Don't forget to 
set you web server up to ram everything through `index.php`.



## What You Should Do With This Information

This little framework is actually pretty useful for simple projects.  Use
it to make a blog.  Or a simple API.  Or whatever.  More importantly,
read the code and notice how simple the basic ideas are.  Learn that you
can also make a framework.  Maybe you can adapt it to what you need 
rather that using an out of the box bloated framework.

