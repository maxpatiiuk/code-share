# 4th version

Date: December 24, 2016

[Video Overview](https://www.youtube.com/watch?v=9wXwVNZTE_I&list=PLMj6OBMQMwt9dZ8iCiA61ksbCVCxp_c96&index=3)

When achieving this website, the source code was edited to replace absolute URLs
(http://mambo.zzz.com.ua/) with a `LINK` constant to make it easier to host it
as part of a monorepo.

## Deployment

1. Change `LINK` constant in [config.php](./config.php) to address at which
   website will be publicly available. Make sure the path ends with `/`
2. Install PHP 5.6
3. Install Apache
