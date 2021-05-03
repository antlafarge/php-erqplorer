<?php

// Config
$hideStartingWithDotDirectories = true;
$hideStartingWithDotFiles = true;
$exactFileSize = false;
$dateFormat = 'y/m/d H:i:s';

error_reporting(E_ALL ^ E_NOTICE);

if (is_dir($_SERVER[DOCUMENT_ROOT].urldecode($_SERVER[REQUEST_URI])))
{
	header("Status: 200 OK");
}
else
{
	header("Status: 404 Not Found");
	
	echo '
	<p>Error 404 Not Found</p>
	<p><a href="'.getHost().'">Return to home page</a></p>
	';

	return;
}

header("Content-type:text/html; charset=utf-8");

$fileExtToIcon = array();
$fileClass = 'file-earmark';

$arrowDownClass = 'file-earmark-arrow-down';
$arrowDownExt = array('AIAS','JNLP','LNK','APPREF-MS','URL','WEBLOC','SYM','DESKTOP');
foreach ($arrowDownExt as &$key)
{
	$fileExtToIcon[$key] = &$arrowDownClass;
}

$arrowUpClass = 'file-earmark-arrow-up';
$arrowUpExt = array('ACQ','ADICHT','BKR','BDF','CFG','CFWB','DAT','EDF','FEF','GDF','GMS','IROCK','MFRE','SAC','SCP-ECG','SEED','MSEED','SEGY','SIGIF','WIN','WIN32');
foreach ($arrowUpExt as &$key)
{
	$fileExtToIcon[$key] = &$arrowUpClass;
}

$binaryClass = 'file-earmark-binary';
$binaryExt = array('8BF','A','APK','APP','BAC','BPL','BUNDLE','CLASS','COFF','COM','DCU','DLL','DOL','EAR','ELF','EXE','IPA','JEFF','JAR','XPI','NLM','O','OBB','RLL','S1ES','SO','VAP','WAR','XBE','XAP','XCOFF','XEX','VBX','OCX','TLB','DEH','SCR','BIN');
foreach ($binaryExt as &$key)
{
	$fileExtToIcon[$key] = &$binaryClass;
}

$codeClass = 'file-earmark-code';
$codeExt = array('ADA','ADB','ADS','ASM','S','BAS','BB','BMX','C','CLJ','CLS','COB','CBL','CPP','CC','CXX','CBP','CS','CSS','CSPROJ','D','DBA','DBPRO123','E','EFS','EGT','EL','FOR','FTN','F','F77','F90','FRM','FRX','FTH','GED','GM6','GMD','GMK','GML','GO','H','HPP','HXX','HS','I','INC','JAVA','L','LGT','LISP','M','M4','ML','MSQR','N','NB','P','PAS','PP','P','PHP','PHP3','PHP4','PHP5','PHPS','PHTML','PIV','PL','PM','PLI','PL1','PRG','PRO','POL','PY','R','RED','REDS','RB','RESX','RC','RC2','RKT','RKTL','SCALA','SCI','SCE','SCM','SD7','SKB','SKC','SKD','SKF','SKG','SKI','SKK','SKM','SKO','SKP','SKQ','SKS','SKT','SKZ','SLN','SPIN','STK','SWG','TCL','VAP','VB','VBG','VBP','VIP','VBPROJ','VCPROJ','VDPROJ','XPL','XQ','XSL','Y','SQL','AHK','APPLESCRIPT','AS','AU3','BAT','BAS','BTM','CLASS','CLJS','CMD','COFFEE','INO','EGG','EGT','ERB','GO','HTA','IBI','ICI','IJS','IPYNB','ITC','JS','JSFL','KT','LUA','M','MRC','NCF','NUC','NUD','NUT','PDE','PM','PS1','PS1XML','PSC1','PSD1','PSM1','PYC','PYO','R','RB','RDP','RED','RS','SB2','SB3','SCPT','SDL','SH','SYJS','SYPY','TCL','TNS','VBS','XPL','EBUILD','MCFUNCTION','MCTEMPLATE','NBS','XEX','GBX','GBX','U','DTD','HTML','HTM','XHTML','XHT','ASP','ASPX','ADP','BML','CFM','CGI','IHTML','JSP','LAS','LASSO','LASSOAPP','PHTML','SHTML','STM','ATOM','XML','EML','JSONLD','KPRX','PS','METALINK','MET','RSS','XML','MARKDOWN','MD','SE','INF');
foreach ($codeExt as &$key)
{
	$fileExtToIcon[$key] = &$codeClass;
}

$diffClass = 'file-earmark-diff';
$diffExt = array('DIF','DIFF','PATCH');
foreach ($diffExt as &$key)
{
	$fileExtToIcon[$key] = &$diffClass;
}

$easelClass = 'file-earmark-easel';
$easelExt = array('3DXML','3MF','ACP','AMF','AEC','AR','ART','ASC','ASM','BIM','BREP','C3D','CCC','CCM','CCS','CAD','CATDRAWING','CATPART','CATPRODUCT','CATPROCESS','CGR','CKD','CKT','CO','DRW','DFT','DGN','DGK','DMT','DXF','DWB','DWF','DWG','EASM','EDRW','EMB','EPRT','ESCPCB','ESCSCH','ESW','EXCELLON','EXP','F3D','FCSTD','FM','FMZ','G','GBR','GLM','GRB','GTC','IAM','ICD','IDW','IFC','IGES','IO','IPN','IPT','JT','MCD','MDG','MODEL','OCD','PAR','PIPE','PLN','PRT','PSM','PSMODEL','PWI','PYT','SKP','RLF','RVM','RVT','RFA','S12','SCAD','SCDOC','SLDASM','SLDDRW','SLDPRT','DOTXSI','STEP','STL','STD','TCT','TCW','UNV','VC6','VLM','VS','WRL','X_B','X_T','XE','ZOFZPROJ','BRD','BSDL','CDL','CPF','DEF','DSPF','EDIF','FSDB','GDSII','HEX','LEF','LIB','MS12','OASIS','OPENACCESS','PSF','PSFXL','SDC','SDF','SPEF','SPI','CIR','SREC','SST2','STIL','SV','S1P','S2P','S3P','S4P','TLF','UPF','V','VCD','VHD','VHDL','WGL','3DMF','3DM','3DS','ABC','AC','AMF','AN8','AOI','ASM','B3D','BLEND','BLOCK','BMD3','BDL4','BRRES','BFRES','C4D','CAL3D','CCP4','CFL','COB','CORE3D','CTM','DAE','DFF','DPM','DTS','EGG','FAC','FBX','G','GLB','GLM','GLTF','IO','IOB','JAS','LDR','LWO','LWS','LXF','LXO','M3D','MA','MAX','MB','MPD','MD2','MD3','MD5','MDX','MESH','MM3D','MPO','MRC','NIF','OBJ','OFF','OGEX','PLY','PRC','PRT','POV','R3D','RWX','SIA','SIB','SKP','SLDASM','SLDPRT','SMD','U3D','USD','USDA','USDC','USDZ','USDZ','VIM','VRML97','VIMPROJ','WRL','M','VUE','VWX','WINGS','W3D','X','X3D','Z3D','ZBMX','MDL','PBO','BSP','SMD','CGB','MAP','RMF');
foreach ($easelExt as &$key)
{
	$fileExtToIcon[$key] = &$easelClass;
}

$excelClass = 'file-earmark-excel';
$excelExt = array('XLK','XLS','XLSB','XLSM','XLT','XLTM','XLW');
foreach ($excelExt as &$key)
{
	$fileExtToIcon[$key] = &$excelClass;
}

$fontClass = 'file-earmark-font';
$fontExt = array('ABF','AFM','BDF','BMF','BRFNT','FNT','FON','FOND','MGF','OTF','PCF','PFA','PFB','PFM','PS','SFD','SNF','TDF','TFM','TTF','UFO','WOFF');
foreach ($fontExt as &$key)
{
	$fileExtToIcon[$key] = &$fontClass;
}

$imageClass = 'file-earmark-image';
$imageExt = array('AI','AVE','ZAVE','CDR','CHP','PUB','STY','CAP','CIF','VGR','FRM','CPT','DTP','FM','GDRAW','ILDOC','INDD','MCF','PMD','PPP','PSD','QXD','SLA','SCD','XCF','ACT','ASE','GPL','PAL','ICC','ICM','ART','BLP','BMP','BTI','CD5','CIT','CPT','CR2','CLIP','CPL','DDS','DIB','DJVU','EGT','EXIF','GIF','CRF','ICNS','ICO','IFF','ILBM','LBM','JNG','JPEG','JFIF','JPG','JP2','JPS','KRA','LBM','MAX','MIFF','MNG','MSP','NITF','OTB','PBM','PC1','PC2','PC3','PCF','PCX','PDN','PGM','PI1','PI2','PI3','PICT','PCT','PNG','PNM','PNS','PPM','PSB','PSD','PDD','PSP','PX','PXM','PXR','QFX','RAW','RLE','SCT','SGI','RGB','INT','BW','TGA','TARGA','ICB','VDA','VST','PIX','TIF','TIFF','VTF','XBM','XCF','XPM','ZIF','3DV','AMF','AWG','CGM','CDR','CMX','DP','DXF','E2D','EGT','EPS','FS','GBR','ODG','SVG','STL','VRML','SXD','TGAX','V2D','VDOC','VSD','VSDX','VND','WMF','EMF','ART','XAR','MCMETA','MCPACK','LMP','UTX','VTF','ANI','CUR','SMES','WAD','SPR');
foreach ($imageExt as &$key)
{
	$fileExtToIcon[$key] = &$imageClass;
}

$lockClass = 'file-earmark-lock-2';
$lockExt = array('OPENPGP','GXK','SSH','PUB','PPK','NSIGN','CER','CRT','DER','P7B','P7C','P12','PFX','PEM','PFX','AXX','EEA','TC','KODE','NSIGNEBPW','KDB','KDBX','HTPASSWD');
foreach ($lockExt as &$key)
{
	$fileExtToIcon[$key] = &$lockClass;
}

$medicalClass = 'file-earmark-medical';
$medicalExt = array('CML','MOL','SD','SDF','DX','JDX','SMI','AB1','ACE','ASN','BAM','BCF','BED','CAF','CRAM','DDBJ','EMBL','FASTA','FASTQ','GCPROJ','GENBANK','GFF','GTF','MAF','NCBI','NEXUS','NEXML','NWK','PDB','PHD','PLN','SAM','SBML','SCF','SFF','SRA','STOCKHOLM','SWISS-PROT','VCF','DICOM','DCM','NI','GII','IM','HDR','BRIK','HEAD','MGH','MGZ','MNC','ACQ','ADICHT','BCI2000','BDF','BKR','CFWB','ECGML','EDF','EDF+','FEF','GDF','HL7AECG','MFER','OPENXDF','SCP-ECG','SIGIF','WFDB','XDF','HL7','XDT','CBF','EBF','CBFX','EBFX');
foreach ($medicalExt as &$key)
{
	$fileExtToIcon[$key] = &$medicalClass;
}

$minusClass = 'file-earmark-minus';
$minusExt = array('TEMP','TMP');
foreach ($minusExt as &$key)
{
	$fileExtToIcon[$key] = &$minusClass;
}

$musicClass = 'file-earmark-music';
$musicExt = array('8SVX','16SVX','AAC','ABC','AC3','AIF','AIFC','AIFF','AIMPPL','ALC','ALP','ALS','AMR','APE','ASF','AST','ASX','ATMOS','AU','AUDIO','AUP','AW','BAND','BRSTM','BWF','CDDA','CEL','CPR','CUST','CWP','DARMS','DMKIT','DRM','DSF','DFF','DTS','DTSHD','DTSMA','DWD','ENS','ETF','FLAC','FLP','GP','GP3','GP4','GP5','GPX','GRIR','GSM','GYM','JAM','KERN','LA','LOGIC','LY','M3U','MEI','MID','MIDI','MMP','MMR','MNG','MP1','MP2','MP3','MPC','MSCX','MSCZ','MUS','MUSX','MX6HS','MXL','NFS','NIFF','NPR','OFF','OFR','OFS','OGG','OMF','OMFI','OTS','PAC','PLS','PSF','PTB','PVD','RA','RAM','RIN','RKA','RKAU','RMJ','RAW','REAPEAKS','RM','RPP','RPP-BAK','SES','SFK','SFL','SHN','SIB','SID','SMDL','SMP','SND','SNG','SPC','SPX','STF','SWA','SYN','TAK','THD','TTA','TXM','UST','VCLS','VGM','VOC','VOX','VPR','VQF','VSQ','VSQX','WAV','WV','WMA','XPL','XSPF','YM','ZPL','DVR-MS','WTV','MUS','UMX','USX');
foreach ($musicExt as &$key)
{
	$fileExtToIcon[$key] = &$musicClass;
}

$personClass = 'file-earmark-person';
$personExt = array('XMC','ZED','CONTACT','WAB','VCF','LDIF');
foreach ($personExt as &$key)
{
	$fileExtToIcon[$key] = &$personClass;
}

$playClass = 'file-earmark-play';
$playExt = array('AAF','3GP','ASF','AVCHD','AVI','BIK','BRAW','CAM','COLLAB','DAT','DSH','DVR-MS','FLV','M1V','M2V','NOA','FLA','FLR','SOL','M4V','MKV','WRAP','MNG','MOV','MPEG','THP','MXF','ROQ','NSV','RM','SVI','SMI','SMK','SWF','WMV','WTVYUV','WEBM','BRAW','FCP','MSWMM','PPJ','PRPROJ','IMOVIEPROJ','VEG','VEG-BAK','SUF','WLMP','KDENLIVE','VPJ','MOTN','IMOVIEMOBILE','WFP','WVE','WLMP','PDS','ROQ','VPROJ');
foreach ($playExt as &$key)
{
	$fileExtToIcon[$key] = &$playClass;
}

$postClass = 'file-earmark-post';
$postExt = array('MOD','MT2','S3M','XM','IT','NSF','FTM','BTM','MCADDON','A26','A52','A78','LNX','JAG','J64','WBFS','WDF','GCM','MIN','NDS','CIA','GB','GBC','GBA','SAV','SGM','N64','V64','Z64','U64','USA','JAP','PAL','EUR','NES','FDS','JST','GG','SMS','SG','SMD','32X','SMC','078','SFC','FIG','SRM','ZST','ZS1','ZS2','FRZ','PCE','NPC','NGP','NGC','VB','INT','MIN','VEC','WS','WSC','TZX','TAP','Z80','SNA','DSK','T64','D64','CRT','ADF','ADZ','DMS','VFD','VHD','VUD','VMC','VSV','VMDK','NVRAM','VMEM','VMSD','VMSN','VMSS','STD','VMTM','VMX','VMXF','VDI','VBOX-EXTPACK','HDD','PVS','COW','QCOW','QCOW2','QED');
foreach ($postExt as &$key)
{
	$fileExtToIcon[$key] = &$postClass;
}

$pptClass = 'file-earmark-ppt';
$pptExt = array('POT','PPS','PPT');
foreach ($pptExt as &$key)
{
	$fileExtToIcon[$key] = &$pptClass;
}

$richTextClass = 'file-earmark-richtext';
$richTextExt = array('PDF','EPUB','GDOC','ODM','ODT','OTT','DVI','EGT','PLD','PCL','PS','SNP','XPS','XLS-FO','XSLT','XSL','TPL','MHTML','MHT');
foreach ($richTextExt as &$key)
{
	$fileExtToIcon[$key] = &$richTextClass;
}

$ruledClass = 'file-earmark-ruled';
$ruledExt = array('TSV','CSV','DB','DIF','4DB','4DD','4DINDY','4DINDX','4DR','ACCDB','ACCDE','ADT','APR','BOX','CHML','DAF','DAT','DB','DBF','DTA','EGT','ESS','EAP','FDB','FP','FP3','FP5','FP7','FRM','GDB','GTABLE','KEXI','KEXIC','KEXIS','LDB','LIRS','MDA','MDB','ADP','MDE','MDF','MYD','MYI','NCF','NSF','NTF','NV2','ODB','ORA','PCONTACT','PDB','PDI','PDX','PRC','REC','REL','RIN','SDB','SDF','SQLITE','UDL','WADATA','WALNDX','WAMODEL','WAJOURNAL','WDB','WMDB','AVRO','PARQUET','ORC','ASC','APR','DEM','E00','GEOJSON','GEOTIFF','GML','GPX','ITN','MXD','NTF','OV2','SHP','TAB','DTED','KML','3DT','ATY','CAG','FES','MGMF','MM','MMP','TPC','MML','ODF','SXM','MSG','ORG','PST','OST','SC2','MPP','BIB','ENL','RISFITS','SILO','SPC','EAS3','EOSSA','OST','CCP4','MRC','HITRAN','ROOT','SDF','MYD','NETCDF','HDR','HDF','H4','H5','SDXF','CDF','CGNS','FMF','GRIB','BUFR','PP','NASA-AMES','G6','S6','MCR','MCWORD','DSG','PAK','PK2','PK3','PK4','SAV','UAX','UNR','UPK','UT2','UT3','UXX','DMO','GRP','SV','ITM','SQF','SQM','LIP','VMF','VMX','PCF','HL2','DEM','VPK','VMT','PJ','LOG','CFG','CONF','INI','JSON','JSONQ','CSV','TSV','YAML','RST','BAK','BK','CNF','ZONE','HTACCESS','GITIGNORE','PWF','PTS','RBL','RES','GAM','NAV');
foreach ($ruledExt as &$key)
{
	$fileExtToIcon[$key] = &$ruledClass;
}

$slidesClass = 'file-earmark-slides';
$slidesExt = array('GSLIDES','KEY','KEYNOTE','NB','NBP','ODP','OTP','PEZ','PPTX','PRZ','SDD','SHF','SHOW','SHW','SLP','SSPSS','STI','SXI','THMX','WATCH');
foreach ($slidesExt as &$key)
{
	$fileExtToIcon[$key] = &$slidesClass;
}

$spreadsheetClass = 'file-earmark-spreadsheet';
$spreadsheetExt = array('123','AB2','AB3','AWS','BCSV','CLF','CELL','CSV','GSHEET','NUMBERS','GNUMERIC','LCW','ODS','OTS','QPW','SDC','SLK','STC','SXC','TAB','VC','WK1','WK3','WK4','WKS','WQ1','XLSX','XLR','MYO','MYOB','TAX','YNAB','IFX','OFX','QFX','QIF');
foreach ($spreadsheetExt as &$key)
{
	$fileExtToIcon[$key] = &$spreadsheetClass;
}

$textClass = 'file-earmark-text';
$textExt = array('0','1ST','600','602','ABW','ACL','AFP','AMI','ANS','ASC','AWW','CCF','CSV','CWK','DBK','DITA','DOTX','DWD','EGT','EZW','FDX','FTM','FTX','HWP','HWPML','LWP','MBP','MD','ME','MCW','MOBI','NB','NBP','NEIS','NT','NQ','ODOC','OSHEET','OMM','PAGES','PAP','PDAX','QUOX','RADIX','RTF','RPT','SDW','SE','STW','SXW','TEX','INFO','TROFF','TXT','TEXT','UOF','UOML','VIA','WPD','WPS','WPT','WRD','WRF','WRI','XML','XPS','ASC','NFO');
foreach ($textExt as &$key)
{
	$fileExtToIcon[$key] = &$textClass;
}

$wordClass = 'file-earmark-word';
$wordExt = array('DOC','DOCM','DOCX','DOT','MCW','ACL');
foreach ($wordExt as &$key)
{
	$fileExtToIcon[$key] = &$wordClass;
}

$xClass = 'file-earmark-x';
$xExt = array('!UT','CRDOWNLOAD','OPDOWNLOAD','PART','PARTIAL');
foreach ($xExt as &$key)
{
	$fileExtToIcon[$key] = &$xClass;
}

$zipClass = 'file-earmark-zip';
$zipExt = array('?MN','?Q?','7Z','AAPKG','AAC','ACE','ALZ','APK','APPX','AT3','BKE','ARC','ARJ','ASS','SAS','B','BA','BIG','BIN','BJSN','BKF','BZIP2','BLD','CAB','C4','CALS','XAML','CLIPFLAIR','CPT','SEA','DAA','DEB','DMG','DDZ','DN','DPE','EGG','EGT','ECAB','ESD','ESS','FLIPCHART','GBP','GBS','GHO','GIF','GZIP','IPG','JAR','LBR','LQR','LHA','LZIP','LZO','LZMA','LZX','MBW','MPQ','BIN','NL2PKG','NTH','OAR','OSK','OSR','OSZ','PAK','PAR','PAF','PEA','PYK','PK3','PK4','RAR','RAG','RAGS','RAX','RBXL','RBXLX','RPM','SB','SB2','SB3','SEN','SIT','SIS','SISX','SKB','SQ','SWM','SZS','TAR','TGZ','TB','TIB','UHA','UUE','VIV','VOL','VSA','WAX','WIM','XAP','XZ','Z','ZOO','ZIP','ISO','NRG','IMG','ADF','DSK','D64','SDI','MDS','MDX','DMG','CDI','CUE','CIF','C2D','DAA','B6T','MAF','GZ');
foreach ($zipExt as &$key)
{
	$fileExtToIcon[$key] = &$zipClass;
}

function getHost()
{
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	{
		$url = "https://";
	}
	else
	{
		$url = "http://";
	}
	$url .= $_SERVER['HTTP_HOST'];
	return $url;
}

function getUrl()
{
	$url = getHost();
	$url .= $_SERVER['REQUEST_URI'];
	return $url;
}

function getFiles($path, $showDirs = true, $showFiles = true, $sort = false)
{
	global $hideStartingWithDotDirectories;
	global $hideStartingWithDotFiles;

	if (!is_dir($path) || ($dh = opendir($path)) === false)
	{
		return false;
	}

	$files = array();

	while (($file = readdir($dh)) !== false)
	{
		if ($file === '.' || $file === '..')
		{
			continue;
		}
		
		$filepath = "$path/$file";

		if (is_dir($filepath))
		{
			if (!$showDirs || ($hideStartingWithDotDirectories && $file[0] === '.'))
			{
				continue;
			}
		}
		else
		{
			if (!$showFiles || ($hideStartingWithDotFiles && $file[0] === '.'))
			{
				continue;
			}
		}

		$files[] = $file;
	}

	closedir($dh);

	if ($sort)
	{
		sort($files);
	}

	return $files;
}

function listDirectories($path, $uri, $indentCount = 1)
{
	$currentPath = $_SERVER[DOCUMENT_ROOT].urldecode($_SERVER[REQUEST_URI]);

	if (substr($currentPath, -1) === '/')
	{
		$currentPath = mb_substr($currentPath, 0, -1);
	}

	$slashes = str_repeat('&nbsp;', 2 * $indentCount);

	$files = getFiles($path, true, false, true);

	if ($files === false)
	{
		echo '<h5 class="text-danger">Error 404 Not Found</h5>';
		return;
	}

	foreach ($files as $file)
	{
		$filepath = "$path/$file";
		$class = 'dir';

		if (strpos($currentPath, $filepath) === 0)
		{
			$img = '<i class="bi bi-folder2-open"></i>';
			$listSubDirectories = true;
			if ($currentPath === $filepath)
			{
				$class = 'dir-opened';
			}
		}
		else
		{
			$img = '<i class="bi bi-folder"></i>';
			$listSubDirectories = false;
		}

		$dirUri = "$uri/$file";

		echo '<tr><td>'.$slashes.'<a href="'.$dirUri.'">'.$img.' <span class="'.$class.'">'.$file.'</span></a></td></tr>';
		
		if ($listSubDirectories)
		{
			listDirectories($filepath, $dirUri, $indentCount + 1);
		}
	}
}

function listFiles($path)
{
	global $exactFileSize;
	global $dateFormat;
	global $fileExtToIcon;

	$type = array(' B','KB','MB','GB');
	$typeIndex = 0;
	$totalFileSize = 0;

	$files = getFiles($path, false, true, true);

	if ($files === false)
	{
		echo '<h5 class="text-danger">Error 404 Not Found</h5>';
		return;
	}

	$filesCount = count($files);

	if ($filesCount === 0)
	{
		echo '<h5>No files</h5>';
		return;
	}

	echo '
	<table class="table table-sm table-hover ftp-sub-table">
		<tr>
			<th class="text-start">Filename</th>
			<th class="text-end">Size</th>
			<th>Date</th>
		</tr>
	';

	foreach ($files as $file)
	{
		$filepath = "$path$file";
		
		$bi = 'file-earmark';
		if (($extPos = strrpos($file, '.')) !== false)
		{
			$ext = strtoupper(substr($file, $extPos + 1));
			if (($biTmp = $fileExtToIcon[$ext]) != null)
			{
				$bi = $biTmp;
			}
		}

		$icone = '<i class="bi bi-'.$bi.'"></i>';

		if (($fileSize = filesize($filepath)) !== false)
		{
			$totalFileSize = $totalFileSize + $fileSize;
			if (!$exactFileSize)
			{
				for ($typeIndex = 0; ($fileSize / 1024 ) > 1 && i < 4; $typeIndex++)
				{
					$fileSize /= 1024;
				}
			}
			
			$fileSize = number_format($fileSize, 0, '.', ' ');
		}
		else
		{
			$fileSize = '-';
		}

		$date = filemtime($filepath);
		$date = date($dateFormat, $date);

		$fileUri = "$uri".urldecode($_SERVER[REQUEST_URI])."$file";

		echo '
		<tr>
			<td><a href="'.$fileUri.'" target="_blank">'.$icone.' '.utf8_encode($file).'</a></td>
			<td class="text-end">'.$fileSize.' '.$type[$typeIndex].'</td>
			<td class="text-center">'.$date.'</td>
		</tr>
		';
	}

	if (!$exactFileSize)
	{
		for ($typeIndex = 0 ; ($totalFileSize / 1024) > 1 && i < 4 ; $typeIndex++)
		{
			$totalFileSize /= 1024;
		}
	}

	$totalFileSize = number_format($totalFileSize, 0, '.', ' ');

	echo '
		<tr>
			<th class="text-start">'.$filesCount.' files</th>
			<th class="text-end">'.$totalFileSize.' '.$type[$typeIndex].'</th>
			<th></th>
		</tr>
	</table>
	';
}

function displayBreadcrumb($title, $uri)
{
	echo '<li class="breadcrumb-item active" aria-current="page"><a href="'.$uri.'">'.$title.'</a></li>';
}

function displayBreadcrumbs($path)
{
	$dirs = split('/', $path);

	echo '
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
	';

	$uri = '/';

	displayBreadcrumb(getHost(), $uri);

	foreach ($dirs as &$value)
	{
		if ($value != null)
		{
			$uri .= "$value/";
			displayBreadcrumb($value, $uri);
		}
	}
	
	echo '
		</ol>
	</nav>
	';
}

?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="erqsor" />
	<meta name="description" content="PHP-ErqPlorer (PHP explorer)" />
	<meta name="keywords" content="FTP, PHP, ErqPlorer, explorer" />
	<link rel="icon" href=".favicon.ico" />
	<link rel="icon" type="image/png" sizes="16x16" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAD1BMVEXf2tGelYtsZF1AOTQMCQhMPdqIAAAACXBIWXMAAAsTAAALEwEAmpwYAAAFzmlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDggNzkuMTY0MDM2LCAyMDE5LzA4LzEzLTAxOjA2OjU3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOk1vZGlmeURhdGU9IjIwMjEtMDUtMDNUMDI6MjM6MDErMDI6MDAiIHhtcDpDcmVhdG9yVG9vbD0iMTEuNC4xIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOC0wOC0yMVQwMDo1MzowNSIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMS0wNS0wM1QwMjoyMzowMSswMjowMCIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjIiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTItMSBibGFjayBzY2FsZWQiIHBob3Rvc2hvcDpEYXRlQ3JlYXRlZD0iMjAxOC0wOC0yMVQwMDo1MzowNS43OTUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MGExZmNjMjctMWEzMS0xMjQ0LTgwNTAtZmZhYzE0ZWNkOTE5IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjBhMWZjYzI3LTFhMzEtMTI0NC04MDUwLWZmYWMxNGVjZDkxOSIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjBhMWZjYzI3LTFhMzEtMTI0NC04MDUwLWZmYWMxNGVjZDkxOSI+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImRlcml2ZWQiIHN0RXZ0OnBhcmFtZXRlcnM9ImNvbnZlcnRlZCBmcm9tIGltYWdlL2pwZWcgdG8gaW1hZ2UvcG5nIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDowYTFmY2MyNy0xYTMxLTEyNDQtODA1MC1mZmFjMTRlY2Q5MTkiIHN0RXZ0OndoZW49IjIwMjEtMDUtMDNUMDI6MjM6MDErMDI6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMS4wIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPHhtcE1NOkRlcml2ZWRGcm9tIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+AHS69wAAAGVJREFUGBkFwQEBAAAIg7AL9M/stioFsKxV3t2OO7Nlmll32uIsTRJbR7ltkDaHuu1EdBAUCia788jt9JJxp523PGV3YcpJ4DyxOjRwQZxBxTnd2a5R2BRr56xqVXXHrGpVdTSremZpAq0Z0Jp6AAAAAElFTkSuQmCC" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<title><?=$_SERVER["HTTP_HOST"]?></title>
	<style>
		body { font-family:consolas; }
		h1 { text-align:center; margin-top:1rem; }
		h5 { text-align:center; margin-top:1rem; }
		a { text-decoration:none; color:#0d6efd; }
		a:hover { text-decoration:none; color:#0a58ca; }
		a:visited { color:#4b2f89; }
		th { text-align:center; }
		.ftp-table { width:100%; border-collapse:collapse; }
		.ftp-cell { vertical-align:top; padding:0; border:1px solid #0d6efd; }
		.ftp-cell-dirs { min-width:20%; max-width:50%; }
		.ftp-cell-files { min-width:50%; max-width:80%; }
		.ftp-sub-table { margin-bottom:0; }
		.dir {}
		.dir-opened { font-weight:bold; }
		.footer { margin-top:1rem; }
	</style>
</head>

<body>

<div class="container-fluid">

<div class="row">
		<div class="col">
			<h1>
				<a href="<?=getHost()?>">
					<?=$_SERVER["HTTP_HOST"]?>
				</a>
			</h1>
		</div>
	</div>

	<div class="row justify-content-md-center">
		<div class="col-10">
			<?php displayBreadcrumbs(urldecode($_SERVER[REQUEST_URI])); ?>
		</div>
	</div>

	<div class="row justify-content-md-center">
		<div class="col-10">
			<table class="ftp-table">
				<tr>
					<td class="ftp-cell ftp-cell-dirs">
						<table class="table table-sm table-borderless table-hover ftp-sub-table">
							<tr>
								<td>
									<a href="/">
										<i class="bi bi-house"></i> <?=getHost()?>
									</a>
								</td>
							</tr>
							<?php listDirectories("$_SERVER[DOCUMENT_ROOT]", getHost()); ?>
						</table>
					</td>
					<td class="ftp-cell ftp-cell-files">
						<?php listFiles($_SERVER[DOCUMENT_ROOT].urldecode($_SERVER[REQUEST_URI])); ?>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row justify-content-md-center">
		<div class="col-10 text-center">
			<p class="footer">
				<a href="https://github.com/antlafarge/php-erqplorer" target="_blank">PHP-ErqPlorer v0.6</a>
			</p>
		</div>
	</div>

</div>

</body>

</html>
