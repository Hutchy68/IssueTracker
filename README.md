## IssueTracker for MediaWiki

The IssueTracker extension is a simple and powerful bug tracking and issue tracking system developed to make this process easier for your team. It introduces the <issues /> tag to the MediaWiki markup, which can be used to produce an issue and bug tracking system.

## Installation

Install by downloading the latest [stable release](https://github.com/Hutchy68/IssueTracker/releases/tag/stable-1.0.2)

1. Place files in your `/extensions` directory

2. In `localsettings.php` add:
```
require_once "$IP/extensions/IssueTracker/IssueTracker.php";
```

Verify installation by browsing to Special:Version.


Disclaimer
==========

Originally developed by Federico Cargnelutti <fedecarg@gmail.com>.

Original source can be found at http://svn.fedecarg.com/repo/MediaWiki/IssueTracker/trunk/

I make no guarantees that this is even going to work. It's someone elses project that looks abandoned, and I'm fixing it up a bit for them.

After a quick look at the source code, it's not following many if any MediaWiki coding guidelines etc, and I doubt the security of it.

Use this AT YOUR OWN RISK.
