1. Use cases

	1. Drag and drop multiple ATutor language packs into the drang&drop area
	2. Wait until files are converted
	3. Click the link with all converted files and download any package
	
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

3. Used resources to learn/use for this program:

	* ConvertCharset.php library for character set conversion:
		http://www.phpclasses.org/package/1360-PHP-Conversion-between-many-character-set-encodings.html
		
	* HTML5 Drag and Drop for multiple files
		http://www.appelsiini.net/2009/10/html5-drag-and-drop-multiple-file-upload
		
4. Known issues

	* This webpage is minimalistic and does not use any inclusive UI elements and not very user-friendly.
	* In Firefox. Small inconvenience. Once files are selected for drag and drop, browser will ask to save one of the packages. No matter on what option is chosen files are still been encoded in UTF-8 and available.
	* dropzone dragexit does not trigger. If you hover a language packages in the area, its background will stay coloured.
	
5. Used implementations

	* Inversion of Control. Almost every class is treated as a plugin which is passed into a constructor of another class.
	* The default few global variables are defined through a configuration which is represented as a hash array.
	* encoder.php is a class which could be extended to use any conversion library (for my example I use ConvertCharset).