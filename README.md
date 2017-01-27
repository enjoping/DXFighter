# DXFighter
**!Currently in active development!**
A new DXF writer and reader in PHP which outputs AC1012 (R15) DXF files.
This project is based on [@digitalfotografen/DXFwriter](https://github.com/digitalfotografen/DXFwriter). It's a great tool for basic DXF exports which don't rely on the newest DXF version. Sadly I needed an export which includes ellipses so I've started writing my own exporter based on his work. As we've needed this for a project the code was written as fast as possible so I need a lot of refactoring in the beginning. At the moment this is just a basic construction but I will add the different objects by time.
After adding the first few object types I will start writing a documentation to make you working with this as easy as possible.

[Getting started guide](https://github.com/enjoping/DXFighter/wiki/GettingStarted) 
[Documentation](https://github.com/enjoping/DXFighter/wiki/Documentation) 

##Current development status
I started thinking about how to solve the reading but by now there is not much code for it. I will start with it in 2017 when the writing is ready.

###At the moment the library supports:
 - Arcs
 - Circles
 - Ellipses
 - Lines
 - LWPolyline
 - Points
 - Polyline
 - Text