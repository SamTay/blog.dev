blog.dev
========

LAMP MVC Application

05/13/14

Thomas correctly pointed out that my FrontController was pretty much identical to Sitepoint's. I rewrote it, and it does pretty much the same thing, but now it is in my own style. I tossed away the idea of using the Front Controller as a Singleton; instead I might store it in the Registry. I also have begun to define each method in my PostController & ListController, which is giving me a better idea of how the application will run in this little microframework. Also note, this blog belongs to a single person. Perhaps that was obvious, but I never really mess with blogs. So the create/edit/delete options are available to a single admin user. Other users will simply be viewing items. Things to do:

1. Modify FrontController->run() to either ensure that $params isn't empty, or ensure that functions accept those parameters.

2. Figure out the best practice for getting data from Model -> Controller -> View. I'm guessing this is where the registry comes into play, but should the model pass data directly to the controller and THEN use the registry, or should the model store the data directly in the registry?

3. Where the hell am I going to use Factory Method and Templating?



05/12/14

Focused on the Front Controller, turned it into a Singleton, and came up with a scheme for parsing URI into controller-actions. Well, came up with a well-defined sheme as opposed to the half-ass idea from 05/09. Also made my other controllers extend from  FrontController. The test.php file indicates that my Front Controller is working! I created  ListController and  PostController classes, some simple "view" and "delete" methods, and echoed strings from those methods to make sure they were being called. For example, ListController->view($pg) has a single $pg parameter. Upon requesting "blog.dev/list/view/pg=1", the method is called and echoes "Viewing stuff from the ListController with argument: pg=1". Next up I need to plan out all (or at least many) of the actual actions needed in this application. I will write definitions of those methods in each controller, referring to the model/view classes that aren't defined yet. Things to do:

0. Build the controllers.

1. Ask Thomas : Does an admin panel refer to the site owner's admin panel, or simply a user controlling their profile?

2. Learn how to write an xml file for DB configuration.

3. Learn what RESTful is.

4. What pieces of this application should be in Helper classes?


05/09/14

Started out today a bit frustrated, not knowing where to go. Decided to do away with awkward class names in favor of a fancy recursive autoloader. After a lot of reading and some aimless coding, I have a rough plan of action. My FrontController will have a single instantiation within index.php, the single point of entry. Its method, delegator(), delegates tasks via the URI! For example, the URL blog.dev/posts/view/1/first-item will be explode()'ed into:

model = 'Post';

controller = 'Posts' . 'Controller';

action = 'view';

queryString = ['1', 'first-item'];

Then the class PostsController will be called with this information. So, the rough structure of the website is in motion. Over the weekend I will learn about general databases and using MySQL with PHP. That will allow me to continue developing model classes. So next up,

0. ALSO ! Edit the documentation dummy! The starting comment block has TWO asterisks! Dumb!

1. Study databases through teamtreehouse

2. Set up Post extends Model class

05/08/14

1. [Doug] explained that bootstrap.php is configuration and bootstrap/ is just styling.
2. (Considering using a recursive autoloader function to avoid strange naming conventions.)

05/08/14

1. Figure out why bootstrap.php is a php file, when the bootstrap/ directory only has css/, js/, fonts/.
 
2. Figure out the optimal location for header/footer files.

3. Define the Registry class (in the proper location).

4. Understand the views_Template class, what information it holds, and how I can set $name:$title variables.

5. Modify the views_Template class to my own personal needs.

6. Figure out how to define and use controllers_Front class.

Most useful references thus far:
http://www.phpro.org/tutorials/Model-View-Controller-MVC.html#5
http://book.cakephp.org/2.0/en/getting-started.html#blog-tutorial
