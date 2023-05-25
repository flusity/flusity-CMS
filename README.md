# CMS-PHP-PDO
# 
PHP CMS project, Log In, Sign Up, admin, moderator, user roles, add/edit/delete post, categories, language, files, menu, custom block, backup.sql, update website settings.

![banner](http://manowebas.lt/wp-content/themes/manowebas/assets/img/logo.png)

<p><b>Šiame svetainės administratoriaus valdymo skydelyje yra keliatą funkcijų ir įrankių:</b>
<ul>
<li>Dashboard (informacijos suvestinė)</li>
<li>Users (vartotojai)</li>
<li>Categories (kategorijos)</li>
<li>Posts (pranešimai)</li>
<li>Menu (meniu)</li>
<li>Block (blokai)</li>
<li>Contact Form (kontaktų forma)</li>
<li>Files (failai)</li>
<li>Language (kalba)</li>
<li>Settings (nustatymai)</li>
</ul>
Svetainė naudoja Bootstrap 5.2.3, FontAwesome 6.1.0 ir jQuery 3.6.0 bibliotekas stiliui ir funkcionalumui užtikrinti. Taip pat yra pritaikytas šriftas "Roboto" ir individualizuoti CSS stiliai, kurie apima šiek tiek neoninio efekto.<br>
  <b>Svetainės struktūra susideda iš šių elementų:</b>
Fiksuota viršutinė navigacijos juosta su logotipu, puslapio priekio nuoroda ir prisijungimo/atsijungimo mygtukais.
Šoninė navigacijos juosta (sidebar) su administratoriaus funkcijų ir įrankių sąrašu.
Pagrindinis turinys, kuriame yra keli blokai su skirtingų funkcijų statistika (pvz., kategorijų, vartotojų, pranešimų skaičius).
<br><b>Svetainė taip pat turi JavaScript kodą, kuris apima šias funkcijas:</b>
Puslapio įkėlimas be perkrovimo, kai paspaudžiamos nuorodos su "data-page" atributu.
Automatiškai uždaryti pranešimus (alerts) po 3 sekundžių.
Toggle funkcija šoninės navigacijos juostai išplėsti ar suskleisti.
Atsižvelgiant į šiuos elementus ir funkcijas, svetainė yrap patogus ir funkcionalus administratoriaus valdymo skydelis.
</p>
<b>Šiame projekte pritaikytos apsaugos yra šios:</b>
<ul>
<li>Content Security Policy (CSP): Kodo pradžioje yra CSP antraštė, kuri apriboja išorinių išteklių naudojimą. CSP padeda apsaugoti nuo kai kurių įterpimo atakų, tokių kaip Cross-Site Scripting (XSS).</li>

<li>Sesijos saugumas: secureSession() funkcija apsaugo sesiją naudodama saugesnius nustatymus, tokie kaip saugūs slapukai ir sesijos laiko atnaujinimas. Tai apsaugo nuo kai kurių sesijos grobimo atakų.</li>

<li>Įvesties validacija: validateInput() funkcija naudojama, kad pašalintų HTML žymas, tarpus ir kitus nereikalingus simbolius. Tai padeda apsaugoti nuo kai kurių įterpimo atakų.</li>

<li>CSRF žetonų naudojimas: CSRF žetonai naudojami, kad apsaugotų nuo CSRF atakų. generateCSRFToken() funkcija generuoja žetoną, o validateCSRFToken() tikrina, ar pateiktas žetonas yra teisingas.</li>

<li>Slaptažodžio saugumas: Slaptažodžiai yra saugomi naudojant password_hash() funkciją, kuri naudoja stiprų šifravimo algoritmą (ARGON2I). Tai apsaugo slaptažodžius nuo atakų, kurios bando atskleisti slaptažodžius iš duomenų bazės.</li>

<li>Duomenų bazės saugumas: Duomenų bazės užklausos yra paruoštos naudojant PDO paruoštas pareiškimus, kurie apsaugo nuo SQL injekcijos atakų.</li>
  </ul>
  <p>Prisijungimas prie sistemos: user: Darius password: 1234 , Projektas dar tęsiamas, numatoma pridėti daugiau funkcionalumų</p>
  
  /////// En /////////////////
  <p><b>This website admin control panel contains several features and tools:</b>
<ul><li>
<li>Dashboard (information summary)</li>
<li>Users</li>
<li>Categories</li>
<li>Posts</li>
<li>Menu (menu)</li>
<li>Block</li>
<li>Contact Form</li>
<li>Files</li>
<li>Language</li>
<li>Settings</li>
</ul>
The site uses Bootstrap 5.2.3, FontAwesome 6.1.0 and jQuery 3.6.0 libraries for styling and functionality. There's also a custom Roboto font and custom CSS styles that include a bit of a neon effect.<br>
   <b>The website structure consists of the following elements:</b>
Fixed top navigation bar with logo, page front link and login/logout buttons.
Sidebar with a list of administrator functions and tools.
Main content containing several blocks with statistics for different functions (eg number of categories, users, posts).
<br><b>The site also contains JavaScript code that includes the following functions:</b>
Loading the page without reloading when clicking on links with the "data-page" attribute.
Automatically close notifications (alerts) after 3 seconds.
Toggle function to expand or collapse the side navigation bar.
Considering these elements and functions, the website is a convenient and functional admin control panel.
</p>
  <ul>
<li>Content Security Policy (CSP): There is a CSP header at the beginning of the code that restricts the use of external resources. CSP helps protect against some injection attacks such as Cross-Site Scripting (XSS).</li>

<li>Session Security: The secureSession() function secures the session using more secure settings such as secure cookies and updating the session time. This prevents some session hijacking attacks.</li>

<li>Input Validation: The validateInput() function is used to remove HTML tags, spaces, and other unnecessary characters. This helps protect against some injection attacks.</li>

<li>Use of CSRF tokens: CSRF tokens are used to protect against CSRF attacks. The generateCSRFToken() function generates a token, and validateCSRFToken() checks that the provided token is valid.</li>

<li>Password security: Passwords are stored using the password_hash() function, which uses a strong encryption algorithm (ARGON2I). This protects passwords from attacks that attempt to reveal passwords from the database.</li>

<li>Database security: Database queries are prepared using PDO prepared statements that protect against SQL injection attacks.</li>
   </ul>
   <p>Login to system user: Darius password: 1234 ,The project is still ongoing, it is planned to add more functionalities</p>
   <br>
   
Author's address http://www.manowebas.lt
 
Autoriaus adresas http://www.manowebas.lt


