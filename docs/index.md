## Documentation

### 1 - Install the plugin from the marketplace or via GitHub and enable it

Install this plugin from the Marketplace as super user or download the plugin and install it on your server from FTP in
the `/plugins` folder.


### 2 - Add `_paq` method to your tracking code

This line of code should be placed before `_paq.push(['trackPageView']);`.


```
  _paq.push(['ProfileGravatar.setGravatarHash', '<?php echo hash('sha256', 'user.name@mail.com'); ?>']);
```

(This demo use PHP to hash user email)

Don't forget to adapt `user.name@mail.com' with your own data


### 3 - Enjoy user profil picture un the UserID report or Visit Summary profile
