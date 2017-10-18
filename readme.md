# Bleed Colors

A set of Twig filers for color treatment in [Craft](http://buildwithcraft.com/).
Work in progress.

### Install

Download or clone this repository to ```craft/plugins/bleedcolors```.
***Remember*** to create the ```bleedcolors``` directory before cloning!

### Filters

**hex2rgb**

```twig
Example 01: {{ "#000000"|hex2rgb }}
Example 02: {{ "#000"|hex2rgb(false) }}
```

Convert any hexadecimal to its RGB equivalent and returns it by default as string in ```x,x,x``` format. As seen in the second example, if the optional parameter is set to false, result will be returned as an array.

**brightness**

```twig
{{ "#000"|brightness }}
```

Returns the [perceived brightness](http://alienryderflex.com/hsp.html) of a given hexadecimal.

**isLight / isDark**

```twig
Example 01: {{ "#000000"|isLight }}
Example 02: {{ "#000000"|isLight(60) }}

Example 03: {{ "#000000"|isDark }}
Example 04: {{ "#000000"|isDark(60) }}
```

Returns lightness or darkness as a boolean, based on a given threshold. The default threshold is ```130```, but can be altered via the optional parameter as seen in examples 02 and 04.

## Changelog

### 0.9
- Initial Release