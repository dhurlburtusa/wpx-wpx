# WPX/WPX Unit Tests

These are the unit tests for WPX/WPX.

Most of the methods depend on being used in a WordPress environment. Setting up a WordPress environment isn't appropriate for unit testing. So, we are limited on what can be tested in these unit tests. Many, actually most, of the unit tests just check for the existence of the methods. This ensures no method has been removed. That is, it helps ensure the API is not regressing.
