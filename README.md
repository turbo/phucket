# phucket

A trivial IP-based request limiter. Simply include the file in any PHP script and call `phucket(n)` before anything else to limit the request rate to *n/IP/s*.

Returns `1` if request is allowed, `-1` if not.

Example:

```php
<?php

include 'phucket.php';

die(phucket(5) === -1 ? "nope" : "hi");
```
