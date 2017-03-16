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
that is _not_ the terrible PHP global design pattern seen elsewhere using 
`getenv` (Don't even get me started, an entire much lauded package for solving a problem
in a miserably global way using miserably capitalized ancient config-style naming that 
amounts to a one-liner loading an `.ini` file... Really? Who thought this was a good idea?). 
Don't forget to set you web server up to ram everything through 
`index.php`.  Don't be a dope and entertain class name collision, or else update
the autoloading mechanism to use namespaces.



## What You Should Do With This Information

This little framework is actually pretty useful for simple projects.  Use
it to make a blog.  Or a simple API.  Or whatever.  More importantly,
read the code and notice how simple the basic ideas are.  Learn that you
can also make a framework.  Maybe you can adapt it to what you need 
rather that using an out of the box bloated framework.



## A Different Route

Yeah, that was supposed to be funny.  If you decide to hack this project 
for your next project's framework, you might note that you can simplify 
the routing by simply initializing the route array manually.  You should 
take care to do this in an initializer method utilized by the constructor, 
as PHP does not support anonymous functions in class variables defined 
in the class.  You can do it something like this:

```
<?php

    class Route {
   
        private $routes;
   
        public function __construct() {
            $this->defineRoutes();
        }
        
        public function defineRoutes() {
            $this->routes = ['/foo/i' => function() { return 'I ate foo.'; },
                             '/bar\/(\S+)/i' => function($id) { return 'My bar ID.' }];
        }
   
        public function handle() {
            foreach ($this->routes as $regex => $callback) {
                if (preg_match($regex, $_SERVER['REQUEST_URI'], $params)) {
                    array_shift($params);
                    return call_user_func_array($callback, array_values($params));
                }
            }
            return 'Routing error!';
        }
    }
    
    (new Route())->handle();
```

So yeah, it is easy to clone this project and use it as is, but it is also really easy to 
write your own fairly featureful router based on some of the ideas.  Maybe you just add an 
autoloader to the above and roll with it.  I mean really, the above has two matched routes
and a default route and is less than 30 lines.  If you want to use nomenclature like `[:id]` 
for the routes, you can just replace whatever your definitions are for a regular expression 
with these keywords and swap them out at evaluation time.  Or better yet quit being a 
wimp and just be good with regular expressions.  You can also put an autoloader in here and 
have a really simple one file router that connects to your domain logic.  This isn't real 
tough stuff.
