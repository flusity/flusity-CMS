# flusity CMS
 ![banner](http://manowebas.lt/wp-content/uploads/2023/06/flusity-b.png) v2

<p>PHP CMS project, Log In, Sign Up, admin, moderator, user roles, add/edit/delete post, layout places, language, files, menu, custom block, backup.sql, update website settings.</p>
<p><b>CMS flusity</b> naudoja tradicinį serverio pusės generavimo modelį, bet sukurta naudojant šiuolaikines technologijas ir geriausias praktikas.</p>
<p><b>CMS flusity</b> uses a traditional server-side generation model, but is built with modern technology and best practices.</p>


<p><b>CMS flusity</b>"Flusity CMS"</b> naudoja PHP kaip savo pagrindinę serverio pusės programavimo kalbą.<p>
<p>Projekte naudojama MySQL duomenų bazė.</p>
<p>Šiame Projekte naudojamas "Bootstrap" - tai vienas iš populiariausių "front-end" karkasų.</p>
<p>Taip pat naudojamas jQuery, kuri yra lengva naudoti ir lanksti JavaScript biblioteka, skirta efektyviam DOM manipuliavimui ir AJAX užklausoms.</p>
<p>Kaip ir daugumoje interneto svetainių, "Flusity-CMS" naudoja HTML ir CSS svetainės struktūrai ir stiliui.</p>
<p>Projekte taip pat naudojama "Model-View-Controller" (MVC) architektūra, kuri padeda išlaikyti kodą tvarkingą ir gerai organizuotą.</p>

<b>Šiame "flusity" svetainės administratoriaus valdymo skydelyje yra šios funkcijos:</b>
<h3>Prietaisų skydelis</h3>
<ul>
<li>Dashboard (informacijos suvestinė)</li>
<li>Users (vartotojai)</li>
<li>Places (Vietos)</li> // "Tai vietos puslapio dalyse kur pateikti blokų info"
<li>Posts (pranešimai)</li>
<li>Menu (meniu)</li>
<li>Block (blokai)</li>
<li>Tags (Žymos)</li>
<li>Contact Form (kontaktų forma dar kūrimo būsenoje)</li>
<li>Files (failai)</li>
<li>Language (kalba vertimas į lt)</li>
<li>Settings (nustatymai)</li>
 <li>Database backup (Duomenų bazės kopijų kūrimas)</li>
<li>SEO (description keywords system)</li>
</ul>
<h3>Profilis</h3> 
<p>Sukurta paprasto vartotojo sritis</p>
<p>Svetainė naudoja Bootstrap 5.2.3, FontAwesome 6.1.0 ir jQuery 3.6.0 bibliotekas stiliui ir funkcionalumui užtikrinti. Taip pat yra pritaikytas šriftas "Roboto" ir individualizuoti CSS stiliai, kurie apima šiek tiek neoninio efekto.<br>
  <b>Svetainės struktūra susideda iš šių elementų:</b>
Fiksuota viršutinė navigacijos juosta su logotipu, puslapio priekio nuoroda ir prisijungimo/atsijungimo mygtukais.
Šoninė navigacijos juosta (sidebar) su administratoriaus funkcijų ir įrankių sąrašu.
Pagrindinis turinys, kuriame yra keli blokai su skirtingų funkcijų statistika (pvz., kategorijų, vartotojų, pranešimų skaičius).
<br><b>Svetainė taip pat turi JavaScript kodą, kuris apima šias funkcijas:</b>
Puslapio įkėlimas be perkrovimo, kai paspaudžiamos nuorodos su "data-page" atributu.
Automatiškai uždaryti pranešimus (alerts) po 3 sekundžių.
Offcanvas funkcija šoninės navigacijos juostai išplėsti ar suskleisti.
Atsižvelgiant į šiuos elementus ir funkcijas, svetainė yrap patogus ir funkcionalus administratoriaus valdymo skydelis.
</p>
<br>
<b>Šiame projekte pritaikytos apsaugos yra šios:</b>
<ul>
<li>Content Security Policy (CSP): Kodo pradžioje yra CSP antraštė, kuri apriboja išorinių išteklių naudojimą. CSP padeda apsaugoti nuo kai kurių įterpimo atakų, tokių kaip Cross-Site Scripting (XSS).</li>

<li>Sesijos saugumas: secureSession() funkcija apsaugo sesiją naudodama saugesnius nustatymus, tokie kaip saugūs slapukai ir sesijos laiko atnaujinimas. Tai apsaugo nuo kai kurių sesijos grobimo atakų.</li>

<li>Įvesties validacija: validateInput() funkcija naudojama, kad pašalintų HTML žymas, tarpus ir kitus nereikalingus simbolius. Tai padeda apsaugoti nuo kai kurių įterpimo atakų.</li>
  <li>Vartotojų registracijos draudimas su netinkamo pavadinimo vardais, su galimybe juos papildyti, taip pat apsauga registruojant apsimestiniu administratoriaus vardu</li>
<li>CSRF žetonų naudojimas: CSRF žetonai naudojami, kad apsaugotų nuo CSRF atakų. generateCSRFToken() funkcija generuoja žetoną, o validateCSRFToken() tikrina, ar pateiktas žetonas yra teisingas.</li>

<li>Slaptažodžio saugumas: Slaptažodžiai yra saugomi naudojant password_hash() funkciją, kuri naudoja stiprų šifravimo algoritmą (ARGON2I). Tai apsaugo slaptažodžius nuo atakų, kurios bando atskleisti slaptažodžius iš duomenų bazės.</li>

<li>Duomenų bazės saugumas: Duomenų bazės užklausos yra paruoštos naudojant PDO paruoštas pareiškimus, kurie apsaugo nuo SQL injekcijos atakų.</li>
  </ul>
  <p>Prisijungimas prie sistemos: user: Darius, Admin, User, Moderator password: 1234 , Projektas dar tęsiamas, numatoma pridėti daugiau funkcionalumų</p>
  
  /////// En /////////////////
<p><b>CMS flusity</b>Flusity CMS</b> uses PHP as its main server-side programming language.<p>
<p>The project uses a MySQL database.</p>
<p>This project uses Bootstrap - one of the most popular front-end frameworks.</p>
<p>Also uses jQuery, which is an easy-to-use and flexible JavaScript library for efficient DOM manipulation and AJAX requests.</p>
<p>Like most websites, Flusity-CMS uses HTML and CSS to structure and style the website.</p>
<p>The project also uses Model-View-Controller (MVC) architecture, which helps keep the code neat and well-organized.</p>
<br>
<b>This site admin control panel includes the following features:</b>
  <h3>Dashboard</h3>
<ul><li>
<li>Dashboard (information summary)</li>
<li>Users</li>
<li>Places</li>// "These are places in the parts of the page where block info can be presented"
<li>Posts</li>
<li>Menu (menu)</li>
<li>Block</li>
 <li>Tags</li>
<li>Contact Form</li>
<li>Files</li>
<li>Language (default en)</li>
<li>Settings</li>
<li>Database backup</li>
<li>SEO (description keywords system)</li>
</ul>
<h3>Profile</h3>
<p>Common user area created</p>
<p>The site uses Bootstrap 5.2.3, FontAwesome 6.1.0 and jQuery 3.6.0 libraries for styling and functionality. There's also a custom Roboto font and custom CSS styles that include a bit of a neon effect.<br>
   <b>The website structure consists of the following elements:</b>
Fixed top navigation bar with logo, page front link and login/logout buttons.
Sidebar with a list of administrator functions and tools.
Main content containing several blocks with statistics for different functions (eg number of categories, users, posts).
<br><b>The site also contains JavaScript code that includes the following functions:</b>
Loading the page without reloading when clicking on links with the "data-page" attribute.
Automatically close notifications (alerts) after 3 seconds.
Offcanvas function to expand or collapse the side navigation bar.
Considering these elements and functions, the website is a convenient and functional admin control panel.
</p>
  <ul>
<li>Content Security Policy (CSP): There is a CSP header at the beginning of the code that restricts the use of external resources. CSP helps protect against some injection attacks such as Cross-Site Scripting (XSS).</li>

<li>Session Security: The secureSession() function secures the session using more secure settings such as secure cookies and updating the session time. This prevents some session hijacking attacks.</li>

<li>Input Validation: The validateInput() function is used to remove HTML tags, spaces, and other unnecessary characters. This helps protect against some injection attacks.</li>
<li> Prohibition of registration of users with incorrect names, with the possibility of adding them, as well as protection against registration under a fake administrator name</li>
<li>Use of CSRF tokens: CSRF tokens are used to protect against CSRF attacks. The generateCSRFToken() function generates a token, and validateCSRFToken() checks that the provided token is valid.</li>

<li>Password security: Passwords are stored using the password_hash() function, which uses a strong encryption algorithm (ARGON2I). This protects passwords from attacks that attempt to reveal passwords from the database.</li>

<li>Database security: Database queries are prepared using PDO prepared statements that protect against SQL injection attacks.</li>
   </ul>
   <p>Login to system user: Darius, Admin, User, Moderator password: 1234 ,The project is still ongoing, it is planned to add more functionalities</p>
   <br>
   
Author's address http://www.manowebas.lt
 
Autoriaus adresas http://www.manowebas.lt
![banner](http://manowebas.lt/wp-content/uploads/2023/06/admin-dashboard.jpg)
![banner](http://manowebas.lt/wp-content/uploads/2023/06/log-ser.jpg)
![banner](http://manowebas.lt/wp-content/uploads/2023/06/rg-user.jpg)
![banner](http://manowebas.lt/wp-content/uploads/2023/06/users-system.jpg)
![banner](http://manowebas.lt/wp-content/uploads/2023/06/settings.jpg)
![banner](http://manowebas.lt/wp-content/uploads/2023/06/posts-system.jpg)
![banner](http://manowebas.lt/wp-content/uploads/2023/06/files-system.jpg)
![banner](http://manowebas.lt/wp-content/uploads/2023/06/front.jpg)




