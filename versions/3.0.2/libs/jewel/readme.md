# .jewel - PHP Layout templating framework for FacioCMS
Jewel is brand new layout interpreter for FacioCMS. 

# Usage
Via CLI:
```bash
php PATH_TO_JEWEL/src/CLI/CLI.php PATH_TO_JEWEL_FILE.jewel PATH_TO_DIST_FILE.php
```

# Example usages:
```php
    *foreach($numbers as $number)
        <h1>Your number is: {$number} doubled it is: {$number*2} </h1>
        <h2>Facts about your number: </h2>

        <p>
            Number {$number} is: *if($number % 2 === 0) even *elseif($number === 50) half of 100 *else odd *endif
        </p>
    *endforeach
```

```php
    *for($i = 0; $i < 10; $i++) 
        *if($i % 2 == 0)
            Number {$i} is even
        *endif
    *endfor
```

# To Fix:
+ Switch / Case syntax doesn't works