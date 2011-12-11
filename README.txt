
1. Supported browsers. Tested on:

	* Firefox version 8.0.1
	* Chrome version 15.0.874.121


2. How to use:

	1. Select multiple ATutor language packages which you need to convert to UTF-8 on your computer
	2. Drag and Drop them into the area which tells you "Drop ATutor files here"
	3. Wait until files are being converted
	4. Open the link which has an archive of all converted language packs
	
	
2. Supported Charsets:

	WINDOWS
		windows-1250 - Central Europe
		windows-1251 - Cyrillic
		windows-1252 - Latin I
		windows-1253 - Greek
		windows-1254 - Turkish
		windows-1255 - Hebrew
		windows-1256 - Arabic
		windows-1257 - Baltic
		windows-1258 - Viet Nam
		cp874 - Thai - this file is also for DOS
	
	
	DOS
		cp437 - Latin US
		cp737 - Greek
		cp775 - BaltRim
		cp850 - Latin1
		cp852 - Latin2
		cp855 - Cyrylic
		cp857 - Turkish
		cp860 - Portuguese
		cp861 - Iceland
		cp862 - Hebrew
		cp863 - Canada
		cp864 - Arabic
		cp865 - Nordic
		cp866 - Cyrylic Russian (this is the one, used in IE "Cyrillic (DOS)" )
		cp869 - Greek2
	
	
	MAC (Apple)
		x-mac-cyrillic
		x-mac-greek
		x-mac-icelandic
		x-mac-ce
		x-mac-roman
	
	
	ISO (Unix/Linux)
		iso-8859-1
		iso-8859-2
		iso-8859-3
		iso-8859-4
		iso-8859-5
		iso-8859-6
		iso-8859-7
		iso-8859-8
		iso-8859-9
		iso-8859-10
		iso-8859-11
		iso-8859-12
		iso-8859-13
		iso-8859-14
		iso-8859-15
		iso-8859-16
	
	
	MISCELLANEOUS
		gsm0338 (ETSI GSM 03.38)
		cp037
		cp424
		cp500 
		cp856
		cp875
		cp1006
		cp1026
		koi8-r (Cyrillic)
		koi8-u (Cyrillic Ukrainian)
		nextstep
		us-ascii
		us-ascii-quotes
	
	
	DSP implementation for NeXT
		stdenc
		symbol
		zdingbat
	
	
	And specially for old Polish programs
		mazovia


3. Sources:

	* ConvertCharset.php library for character set conversion:
		http://www.phpclasses.org/package/1360-PHP-Conversion-between-many-character-set-encodings.html
		
	* Simple tutorial for HTML5 Multiple File Drag and Drop
		http://www.appelsiini.net/2009/10/html5-drag-and-drop-multiple-file-upload
		
		
4. Known issues

	* This webpage is minimalistic and does not use any of the advanced UI elements
	* (FIXED!) In Firefox. Small inconvenience. Once files are selected for drag and drop, browser will ask to save one of the packages. No matter on what option is chosen files are still been encoded in UTF-8 and available.
	* (FIXED!) dropzone dragexit does not trigger. If you hover a language packages in the area, its background will stay coloured.
	
	
5. Some of the ideas

	* Inversion of Control. Almost every class is treated as a plugin which is passed into a constructor of another class which brings more scalability to the page and allows to include or exclude specific parts of the program.
	* Global variables are defined through a configuration array. Another instance of the page could be reconfigured based on the changes of that array.
	* Encoder (encoder.php) is a class which could be modified to use any other library for charset conversion (for my example I used ConvertCharset).
	