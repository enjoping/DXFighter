# DXFighter [![Build Status](https://travis-ci.org/enjoping/DXFighter.svg?branch=master)](https://travis-ci.org/enjoping/DXFighter)
![DXFighter](logo.png)  
**!Currently in active development!**  
A new DXF writer and reader in PHP which outputs AC1012 (R15) DXF files.  
This project is based on [@digitalfotografen/DXFwriter](https://github.com/digitalfotografen/DXFwriter).
It's a great tool for basic DXF exports which don't rely on the newest DXF version.
Sadly I needed an export which includes ellipses so I've started writing my own exporter based on his work.
As we've needed this for a project the code was written as fast as possible so I need a lot of refactoring in the beginning.  
The basic implementation is done and you can use it for your projects. The library currently supports reading and writing for some entity types (see the list below).
In the next weeks I will keep on writing the documentation and add help for how to use the reader.  
If you need help please have a look at the example.php file or open an issue.

[Getting started guide](https://github.com/enjoping/DXFighter/wiki/GettingStarted) 
[Documentation](https://github.com/enjoping/DXFighter/wiki/Documentation) 
[Example code](example.php) 

## Current development status
A first impementation of reading and writing is done. Next steps will be to increase the documentation level and start using it in production for my project.
If you encounter problems or need specific changes so that DXFighter fulfills your usecase feel free to open an issue on github.

### At the moment the library supports writing for following entity types:
 - Arcs
 - Circles
 - Ellipses
 - Lines
 - LWPolyline
 - Points
 - Polyline
 - Text
 
### At the moment the library supports reading for following entity types:
 - Ellipses
 - Lines
 - Polyline
 - Text

## License
This project is published under BSD 3-Clause licence. More information can be found in [the LICENSE file](LICENSE).
