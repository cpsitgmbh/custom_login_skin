.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

Administrator Manual
====================

Installation
------------

The extension can be installed through the typical TYPO3 installation process using the extension manager.
After the installation went through a new backend login screen is applied. It is the extension defaults one.
If you like to change it, you can adjust the extension configuration.

Configuration
-------------

Templates
^^^^^^^^^

You can define a default template for the whole TYPO3 installation or configure templates by host.
Each configuration has to be on a new line. For example:

.. code-block:: text

	EXT:custom_login_screen/Resources/Private/Templates/Login.html
	www.example.com=EXT:ext_key/Resources/Private/Templates/Login.html
	test.example.com=EXT:ext_key/Resources/Private/Templates/TestLogin.html

For none-configured hosts the default template is taken as long as it is host-independent.

Stylesheets
^^^^^^^^^^^

Like you can define the template resources, you can configure the stylesheets.
The only difference is that all css files which apply to the current host are registered.
This means if you define a default stylesheet and one for the (current) host, both files are attached to the backend login screen.