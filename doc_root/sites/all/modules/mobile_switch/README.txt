Mobile Switch module

Simple automatic theme switch for mobile devices, detected by Mobile Detect.

This readme is valid for the Branch 7.x-2+.
For other branches and their versions, please read the appropriate
README.txt files.

DEPENDENCIES
------------

  - Drupal 7.
  - The Mobile Detect PHP class from http://mobiledetect.net.
  - The Libraries API module from drupal.org/project/libraries.
  - The Mobile Detect Import module. This is an included sub-module
    of Mobile Switch.

RECOMMENDED
-----------

  - The Mobile Switch Block module from drupal.org/project/mobile_switch_block.

INSTALL
-------

  1) Make sure that the library directory exists for Mobile Detect.

     Typically, this is:

     - sites/all/libraries/Mobile_Detect/

     or

     - sites/default/libraries/Mobile_Detect/
     - sites/example.com/libraries/Mobile_Detect/

     If this directory does not exist it should be created.

       Note: The directory name Mobile_Detect is case sensitive.

     Multi site installation

       Execute this step only on the main-site.

  2) Download the Mobile Detect class file and install it as a library.

     Exists the library directory from step 1 and exists the class file

     Mobile_Detect.php

     you can skip this installation step.

       Note: The file name Mobile_Detect.php is case sensitive.

     Download the class file optionally from

     a) https://raw.github.com/serbanghita/Mobile-Detect/tags

     or

     b) https://raw.github.com/serbanghita/Mobile-Detect/master/Mobile_Detect.php

     The download from b) usually provides a higher version of the
     Mobile Detect class.
     The module uses the link b).

     The result of proper installation of the Mobile Detect class:

     - sites/all/libraries/Mobile_Detect/Mobile_Detect.php

     or

     - sites/default/libraries/Mobile_Detect/Mobile_Detect.php
     - sites/example.com/libraries/Mobile_Detect/Mobile_Detect.php

     Ultimately, this structure must exist in order to find the
     Libraries API the Mobile Detect class.

     Multi site installation

       Execute this step only on the main-site.

  3) Copy the Libraries API folder to the modules folder in your installation.
     Usually this is sites/all/modules.
     Or use the UI and install it via admin/modules/install.

  4) Copy the Mobile Switch folder to the modules folder in your installation.
     Usually this is sites/all/modules.
     Or use the UI and install it via admin/modules/install.

  5) Enable the modules

     IMPORTANT

     - As first step, enable ONLY the Libraries API module!

     - In the second step, enable the Mobile Switch module and its dependent
       module Mobile Detect Import.

     Enable modules under Administration -> Modules.
     /admin/modules

UPDATE FROM 1 TO 2 BRANCH
-------------------------

  1) Visit the Mobile Switch administration and inspect the configuration
     parameters.
     Make sure that you can remember all the configuration details.

  2) Disable and uninstall Mobile Switch and if used, the
     Mobile Switch Block module.

     Disable and uninstall the Browscap module when it is no longer
     necessary (by other modules, or for logging of user agents).

  3) Follow the steps described in the INSTALL section above.

     Install and enable the Mobile Switch Block module if it was uninstalled
     in the update step 2.

  4) Administer the Mobile Switch module and reconfigure all parameter
     to the previous settings.

     If again the Mobile Switch block module enabled in the update step 3,
     then enable the block 'Mobile switch' in the desktop and mobile theme.

     New Mobile Switch configuration parameter:

     The 'Tablet device' parameter in the 'Basic settings' provides the
     opportunity to decide whether the mobile theme is used when a
     tablet device is detected.

     The 'Mobile Detect' area to configure the Mobile Detect Import settings.
     See README.txt of the Mobile Detect Import module for more details.

ADMINISTER
----------

  1) Administer themes under Appearance.
     /admin/appearance

     - Enable your preffered mobile theme (Not set as default).
     - Use as default theme a 'not mobile theme'.

  2) Administer the Mobile Switch module under:
     Administration -> Configuration -> User interface
     /admin/config/user-interface/mobile-switch

     - Choose your mobile theme.

     If a theme used as mobile theme, their displayed informations on the
     Appearance administration page are altered for better visualisation.

     A Mobile Switch mobile theme is default not available on administration
     pages and in the maintenance mode.

     Mobile theme on administration pages

       Configure the 'Administration usage' in the module 'Basic settings' to
       enable the use of the mobile theme on administration pages.

     Mobile device prevention

       It is possible to bypass the automatic switching to the mobile theme for
       mobile devices.
       This is useful, for example, to exclude large tablets for the theme
       switching.

       To use this,

       administer the 'Advanced' settings under:
       Administration -> Configuration -> User interface -> Mobile Switch
       /admin/config/user-interface/mobile-switch/advanced

       enable the 'Use preventing' option and configure the user agent strings
       for such devices.

       To test this feature, without a real mobile device, it is a good
       solution to use the desktop browser with a user agent switcher extension
       and custom defined user agents.

     For the development of a web site

       Administer the 'Development' settings under:
       Administration -> Configuration -> User interface -> Mobile Switch
       /admin/config/user-interface/mobile-switch/development

       a) Enable/disable the 'Developer modus'.

          If a desktop mobile emulator not detected from Mobile Detect it is
          possible to configure additional user agents.

       b) Enable/disable desktop browser usage of the mobile theme.

  2) Administer the Mobile Detect Import module.

     See README.txt of the module.

DEVELOPMENT
-----------

  Development with Mobile Switch.

  The module provides four system variables:

  1. mobile_switch_ismobiledevice
  2. mobile_switch_istablet
  3. mobile_switch_ismobiletheme
  4. theme_mobile

  - The value of the variables 1., 2. and 3. is a boolean value.
  - The value of the variable 4. is FALSE or the machine name of the used theme.

EXTERNAL RECOURCES
------------------

  Mobile Emulators & Simulators: The Ultimate Guide
  http://www.mobilexweb.com/emulators
