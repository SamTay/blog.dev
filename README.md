blog.dev
========

LAMP MVC Application

05/09/14

Started out today a bit frustrated, not knowing where to go. Decided to do away with awkward class names in favor of a fancy recursive autoloader. After a lot of reading and some aimless coding, I have a rough plan of action. My FrontController will have a single instantiation within index.php, the single point of entry. Its method, delegator(), delegates tasks via the URI! For example, the URL blog.dev/posts/view/1/first-item will be explode()'ed into:

model = 'Post';

controller = 'Posts' . 'Controller';

action = 'view';

queryString = ['1', 'first-item'];

Then the class PostsController will be called with this information. So, the rough structure of the website is in motion. Over the weekend I will learn about general databases and using MySQL with PHP. That will allow me to continue developing model classes. So next up,

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
