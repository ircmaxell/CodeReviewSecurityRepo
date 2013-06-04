Prosperia
=========

Prosperia is a small image hosting website with easy and straight-forward interface.

## Install

 1. Prosperia can sufficiently run on every PHP version 5 install. (The earlier version successfully tested on was `5.3.10`.) The **GD** library must be installed.
 2. Check out the repository to your _DocumentRoot_ (usually `/var/www`, or whereever else you wish to install it).
 3. Make sure you give **write** access to your webserver user (usually `www-data`) on the directories `var`, `var/stor` and `var/tokn`.
   * This is usually accomplished by the following command, assuming default setup: `chown www-data /var/www/var /var/www/var/stor /var/www/var/tokn` and `chmod 700 /var/www/var /var/www/var/stor /var/www/var/tokn`.
 4. Open the site in a web browser and everything is ready to go.

## Usage
The front page presents the visitor with an uploader: here he can select the images he wishes to upload.

Every upload is given a unique identifier with which the content can be retrieved later and a one-use delete code, which, if used, permanently destroys the upload.

## But this is just like [any other image hosting site](http://en.wikipedia.org/wiki/List_of_photo_sharing_websites)!

Well this is some reply I received from many people I showed the project in its early states...

It might seem like, and to some extent, it is. But still, this was not preventing me from spending my time playing around with creating Prosperia.
Sometimes, we have to _reinvent the wheel_. This project exactly serves this purpose. I have been using image sharing sites for a long time now (just like everyone else) and the question sparked my mind: what if I make my own?

The bottom line is: before doing so, I only knew (from a user's perspective) what is usually happening on these sites. So I **had** to see behind the scenes and build up the logic from my own mind.

> Do what the big boys have (already?) done.

With it, came some better understanding. With it, came opportunities to try out approaches. There are tons of development tools and methods we barely use (or even barely _know about_). You can't develop without an aim. And if you can't get an aim by yourself, you can always start creating something which had already been created.

And from this perspective, Prosperia was born. The question isn't _what happens_. The question is: **why not** make my own? All you can get is a win with it. All I got is a win with it. Well... maybe time was lost or _wasted_, but I have learned a couple of things.

(Sorry if this sounded more like a blog post and not like a proper README.)

## Contributions

Because this is a home project (and by its nature, most likely a nowhere-to-go-with project), I would not pledge anything big for it. But, if you wish to contribute with feedback, ideas or even code itself... I think you already know your way around GitHub. We'll see how it works out. :)

## The underlying infrastructure
### `Stor`: The storage object

It is the main container of uploaded data. It stores the information of the upload: timestamp, filename, type, length, and most importantly, the content.

### The storage holders

Storage objects are somehow to be saved after execution (and of course, loaded afterwards). This is where _holders_, most specifically, implementations of `IStorWriter` and `IStorLoader` come to the picture.

Currently, storages can be saved and loaded to a file, and there is a "from data" storage "constructor" to create a storage object for a new upload.

### `Tokn`: The tokens

Tokens are shortcuts between user accessible auto-generated strings (which are present to them after upload) and the underlying storage objects.

### The `Thumbnail` class

It creates a specified size thumbnail from an arbitrary `Stor` object.

### File structure

Tokens and storages are saved to file to `var/tokn` and `var/stor`, respectively.

Everything else is in the code. After all, it is the code who speaks, not my comments.

Thank you for checking my little project out.