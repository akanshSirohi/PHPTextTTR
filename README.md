# PHPTextTTR
PHP library to generate illusion image which can only be readable with tilted screen

## How to use
1) ``` Run index.php to see a sample usage of this library ``` 
2) ``` Read comments in index.php to see how to properly use this library ```

## Tips
1) ``` assets ``` folder is library own folder in which frames and font is present.
2) If you want to create your own frame then make the 4 versions of different dimensions of the same as you can see in ``` assets/frames ``` folder.
3) You can completely modify it and use it in your own way.
4) Feel free to contact me if you want any help regarding to this repo.
5) You can also fork this repo and work on it and make pull request if you can make it more intresting.

## Sample usage
> You can find the same in index.php

1) Include and initialize library
```php
    require("./PHPTextTTR.php");
    $PHPTextTTR = new PHPTextTTR();
```

2) Configure the object according to your needs
```php
    // Both string cannot be more than 50 chracter length each
    // Second string is optional
    $PHPTextTTR->setText("Akansh Sirohi", "Creative Programmer");

    // Set font color and background color of image
    $PHPTextTTR->setColors("#000000", "#ffffff");

    // Use frames in image if set true
    $PHPTextTTR->setUseFrames(true);

    // if set true makes image embedable in image tags, default false
    $PHPTextTTR->setShowEmbed(true);
 ```
 
 3) You can embed it as image src in html after setting ```setShowEmbed``` to ``` true ```
 ```php
    <img src="<?= $PHPTextTTR->generateTTR(false); ?>" width="600">
```
  
  OR <br>
  
  You can force download or show image diretly to page, use these after setting ```setShowEmbed``` to ``` false ```
```php
    // $PHPTextTTR->generateTTR(false); // disabled force download
    // $PHPTextTTR->generateTTR(true); // enabled force download
```

### Happy Coding!
