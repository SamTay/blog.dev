blog.dev
========

LAMP MVC Application

05/23/14 Adjusted header according to session variables, but those variables have not yet been defined. Now when "anonymous" users view the site, they have login and register options in the navbar. I set up UserController, UserModel, UserRegisterView, UserLoginView which do what you think they would. All logic is handled in UserModel (i.e., determining proper username, password, if username already exists, etc.), and the UserModel->register() and ->login() methods return arrays of data which also have a bool entry with key 'success', to let the UserController know if the registration/login was successful or not. It then directs appropriately. Pretty cool, total separation of concerns happened naturally. Jay also made the suggestion to encode passwords with md5, which only took one line of code, so why not.

 NOTE that with session variables, it appears I can refactor code to instead use header('location:') instead of call_usr_func(control,method) to default to certain views (like viewing post after creation, or viewing homepage after deletion). This will also fix the dumb "sticky" URI's. Also my important messages currently stored in the registry will instead be stored as a session variable, I think. If I have time to work this weekend, I'd like to finish up login stuff and possibly start adding commenting options and whatnot. Things to do:

1. Still need to learn session stuff
-> 1.5. Hopefully this will lead to ability to load the last page user was on before login/registration.
2. Have buttons in the forms' textareas for admin/users to easily add HTML styling, without actually typing HTML.
3. Homepage includes N posts -> create pretty pagination to get the next N posts (slideUp maybe?) Also put N in configuration, instead of IndexController
4. Search function
5. Ask Thomas wtf RESTful is

05/22/14 Skipped the daily update yesterday, went to happy hour instead. Yesterday was a good day and I finished all basic CRUD functionality. Thomas gave me a few things to work on such as config.xml and using session/observer pattern to recognize if user is admin or not. I'm still a bit unclear on that.

Today I set up config.xml and created Config class to handle parsing xml. I really wanted to come up with some sort of function that is easy to use like get(key), which would then search through the XML structure recursively for that key. Or get(type,key), etc., since keys aren't unique and I might need db->username or admin->username. It proved difficult, simply because I'm not used to using SimpleXMLElement and SimpleXMLIterator objects. I think I would need either that iterator or the RecursiveIteratorIterator to traverse through the xml, but I decided I was wasting too much time on it and instead just created a basic function to retrieve config information. I also began using the Registry class today to store important messages for the user. If registry->var('msg') exists, it is displayed in a nice looking alert box on the next loaded screen (for example, successfully creating/udpating/deleting a post). I then added a dismissable option, and Jay suggested a fadeout. I used a bit of jQuery from the internet for the fadeout, and Brian suggested the slideUp. The slideUp is pretty, and gives the website a more sleek feel. Other than that, I've been reading about the observer pattern but haven't implemented it yet. I'll need to learn a bit more about login/session stuff. Tomorrow I will work on setting up a user login, and how to use session with observer pattern. To do next:

1. Login/Session/Observer jazz
2. Homepage includes N posts -> create pretty pagination to get the next N posts
3. Search function
4. Have buttons in the create/update forms for users to easily add HTML styling, without actually typing HTML.

05/20/14 Currently working on Create. Got everything working on the backend, then fucked it all up when styling it. Going to work from home tonight. Questions for Thomas:

1. Why I need a list model?
2. How to handle index/index
3. Benefits of config.xml as opposed to the way I have it now?
4. Formatting HTML from database?

05/19/14 This app now has a complete skeleton and basic functionality. I can probably complete all rudimentary features (CRUD) within two days, and then perhaps the next 1-2 weeks will consist of updating certain methodologies or upgrading new features. Today I met with Thomas and he gave me just the bit of direction I needed. Accomplished: Changed URI scheme to allow post/get variables, extended all controllers from FrontController, created factory class within bootstrap.php to getViews and getModels dynamically during runtime, successfully query database via PDO, pass data (via controllers) to view classes that are now generating views with model data. THAT took a while, but it is now working. Things to do next:

1. Finish C,R,U,D methods within PostController, PostModel, PostView.
2. Ask why I need a List Model - can't my lists just consist of data from Posts (like title & date columns?)
3. Ask about the ugly URI blog.dev/index/index
4. Ask how to format HTML from the database; should the bodytext be stored with HTML, or should I somehow format that after retrieving the text?
5. Create column in posts table that stores PATHS to images.
6. Add right column with dates/links.

Longer term tasks: Create admin panel and separate user/admin experience, XML config, figure out how to retrieve total row count in MYSQL



05/15/14

Today I was still taking care of frontend stuff. Made home/about/contact controllers and views. Right now it's set up where all views are derived from View class, which defines the function renderPage, which calls on setHeader,setFooter,setBody. However, setBody is abstract and requires derived children to define. So it's a little weird that derived classes define setBody, and then the parent function calls on setBody to renderPage. I came up with this design to limit code repetition in views.

05/14/14

Wow I did a lot today. Created some inheritance structure in the views classes, and implemented what I think is a Factory. I wanted to get some tangible results out of today, so I've also started to explore the Twitter Bootstrap and set up a few template files. Now my page actually looks like something somewhat interesting. Things to do:

1. Make sure that Views will simply get data from Model via the Registry.

2. Dynamically set which links are active on the front end.

3. Use http://www.sitepoint.com/building-responsive-websites-using-twitter-bootstrap/ to come up with a sidebar that organizes links by date. (this will be its own template that will be loaded onto multiple pages)

4. Should my renderPage function be called from a __destructor??

5. Ask Thomas how to code display depending on if user is admin or not.


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
