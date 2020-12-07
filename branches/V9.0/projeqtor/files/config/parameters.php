<?php 
// =======================================================================================
// PARAMETERS
// =======================================================================================
// ========== Database configuration =====================================================
// --- MySql Degfault
$paramDbType='mysql'; $paramDbPort='3306'; $paramDbUser='root'; $paramDbPassword='mysql';
$paramDbName='projeqtor_v90';$paramDbPrefix='';
// --- PostgreSql Default
//$paramDbType='pgsql'; $paramDbPort='5432'; $paramDbName='projeqtor'; $paramDbUser='projeqtor'; $paramDbPassword='projeqtor';
//$paramDbName='support_ige';$paramDbPrefix=''; 
$paramDbHost='127.0.0.1';          // With MySql on Windows, better use "127.0.0.1" rather than "localhost"

// ========== Log file configuration =====================================================
$logFile='../files/logs/projeqtor_${date}.log';
$logLevel='3';                     // "1"=Errors, "2"=Trace, "3"=Debug, "4"=Script

// ========== Contextual configuration ===================================================
//$lockPassword="false";           // Forbid password change (used in Demo to forbit password change)
//$hosted=true;                    // Is a hosted mode. Hide some configuration. Set to true hides Data Cloning. Set to anything else ('dedicated') enables Data Cloning
//$flashReport=true;               // Specific evolution Parameter
$enforceUTF8 = '1';                // Positionned by default for new installs since V4.4.0
$paramSupportEmail="support@projeqtor.org"; // Email displayed as support mail
$pdfNamePrefix="ProjeQtOr - ";     // Prefix for PDF files 

// ========== Debugging configuration ====================================================
$debugQuery=false;                 // Debug all queries : trace Query and running time for each query
$debugJsonQuery=false;             // Trace only JsonQuery queries  (retrieving lists)
$debugPerf=true;                   // Add some timestamps and execution time at all debug lines
$debugTraceUpdates=false;          // Will add trace on each save() or delete(), except for History and Audit
$debugTraceHistory=false;          // Will add trace on each save() or delete() of History and Audit (only if $debugTraceUpdates=true;)
$debugReport=true;                 // Displays report file name on report header
$i18nNocache=true;                 // Will not cache i18n table, so that new values are automatically displayed without needing disconnection
$debugIEcompatibility=false;       // If set to true, will allow compatibility mode (mode IE9 on IE11), otherwise, edge mode is forced
//$pdfPlanningBeta='true';         // Force new PDF Export planning with all browsers, now works as default and can be only removed using value 'false' *** DEPRECATED ***
$scaytAutoStartup='';            // Activate the Scayt spell checker for CK Editor
//$filenameCharsetForImport="WINDOWS-1252"; //Expected format for files to import
//$paramReorg=false;               // Use new organization of sreens, with buffering, is now defaut behavior, can be only removed using value false *** DEPRECATED ***
//$imapFilterCriteria='UNSEEN';    // Valuie for IMAP filter criteria, default is 'UNSEEN UNDELETED'
$dataCloningDirectory="D:\www\simulation";       // Modifies directory for simulations to avoid Eclipse conflict
$dataCloningUrl="http://localhost/simulation/";  // Acces data cloning url for goto
//$doNotExportAssignmentsForXMLFormat=true;      // Will not be needed anymore on V8.3 as it will become a user parameter
//$pathToWkHtmlToPdf="C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"; // Enables wkHtmlToPdf. Must indicate location of executable.
//$paramDbCollation='utf8_general_ci';
//$paramNewGui=true;
//======= END