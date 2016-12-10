# JEK Framework.
JEK is a small framework meant to follow the conventions an MVC structure gains, which is safer, easier to write code.

JEK runs using MVC-type names,


| Normal         | Jek           |
| -------------- |:-------------:|
| M (Model)      | J (Joint)     |
| V (View)       | E (Entry)     |
| C (Controller) | K (Kontroller |

##Documentation
When starting out using JEK, you need to understand the browser / server stack, and how pieces of browser data is represented in JEK.

If a user connects to your backend framework (**JEK**) at the site `www.example.com`, this is the JEK Stack:

##Routes
The browsers URI (content trailing the slash) is processed in the **Routing.php** file, located in `sys/build/Routing.php`, which lets you manage the slugs the URI is given.

###Slugs
A slug is just a segment in a system that manipulates the URI in a way that it's segmented (like a folder structure), if we have the URL `www.example.com/name/jack`, the first slug is **name** and the second is **jack**.

The Router has a bit of documentation in itself from the comments, but this is how you'd manage an incoming request:

```php
$router = new Router;
  
$router->Get('index', function($kontroller){
  echo "The index was loaded!";
});
```

If you put in `index` as what you're looking for, that just means there's no data in the first slug, so a `www.example.com/` call.
