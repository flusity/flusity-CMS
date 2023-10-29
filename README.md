# flusity CMS
 <p>100% completion</p>
 
 ![banner](https://flusity.com/uploads/banneris_49d80b2a642e06c6.jpg) v 2.304
 
 <h4> Flusity - tai unikalus pavadinimas, kuris atspindi misiją. Jis kilo iš "flussi" ir "city" žodžių, simbolizuojančių duomenų srauto ir plėtros koncepcijas, viską sujungiant į harmoningą "miestą", kuriame viskas juda laisvai ir efektyviai.</h4>

<b>The latest update added the ability to edit and add posts from the front of the page, making web administration much easier.</b>
<p><b>CMS flusity</b> naudoja tradicinį serverio pusės generavimo modelį, bet sukurta naudojant šiuolaikines technologijas ir geriausias praktikas.</p>
<p>PHP TVS projektas, įdiegimas, prisijungimas, registracija, administratorius, moderatorius, vartotojo vaidmenys, pridėjimas / redagavimas / ištrynimas (įrašas, išdėstymo vietos, kalba, failai, meniu, temos, pasirinktinis blokas, priedo (papildo) sistema, naudotojas, backup.sql), atnaujinkite svetainės nustatymus, integruota papildomos kalbos pridėjimas kaip numatytoji savo pasirinkta iš sąrašo 'lt', 'it', 'fr', 'de' ir papildoma kalba 'en'. turint šiek tiek įgūdžių galima pakeisti ir atvirkščiai.</p>
<p>CMS flusity naudoja PHP kaip savo pagrindinę serverio pusės programavimo kalbą.<p>
<p>Projekte naudojama MySQL duomenų bazė.</p>
<p>Šiame Projekte naudojamas "Bootstrap" - tai vienas iš populiariausių "front-end" karkasų.</p>
<p>Taip pat naudojamas jQuery, kuri yra lengva naudoti ir lanksti JavaScript biblioteka, skirta efektyviam DOM manipuliavimui ir AJAX užklausoms.</p>
<p>Kaip ir daugumoje interneto svetainių, "Flusity-CMS" naudoja HTML ir CSS svetainės struktūrai ir stiliui.</p>
<p>Projekte taip pat naudojama "Model-View-Controller" (MVC) architektūra, kuri padeda išlaikyti kodą tvarkingą ir gerai organizuotą.</p>
<p>Įdiegtas prefix palaikymas kuri leidžia veiksmingiau tvarkyti duomenų bazę, nes sukuria aiškią struktūrą ir padeda išvengti pavadinimų konfliktų, ypač kai naudojamas vienas ir tas pats CMS įvairioms svetainėms arba kai įtraukiami įvairūs plėtiniai ir moduliai. Tai ypač naudinga didelėse sistemose ir padeda gerinti saugumą bei duomenų organizavimą.</p>
<b>Šiame "flusity" svetainės administratoriaus valdymo skydelyje yra šios funkcijos:</b>
<h3>Prietaisų skydelis</h3>
<ul>
<li>Dashboard (informacijos suvestinė)</li>
<li>Users (vartotojai)</li>
<li>Places (Vietos) "Tai vietos puslapio dalyse kur pateikti blokų info"</li> 
<li>Posts (pranešimai)</li>
<li>Menu (meniu)</li>
<li>Addons (papildiniai)</li>
<li>Block (blokai)</li>
<li>Tags (Žymos)</li>
<li>Contact Form </li>
<li>Files (failai)</li>
<li>Language (kalba vertimas į lt)</li>
<li>Settings (nustatymai)</li>
 <li>Database backup (Duomenų bazės kopijų kūrimas)</li>
<li>SEO (description keywords system)</li>
<li>Themes (puslapio temos)</li>
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

<li>Slaptažodžio saugumas: Slaptažodžiai yra saugomi naudojant password_hash() funkciją, kuri naudoja stiprų šifravimo algoritmą (PASSWORD_BCRYPT arba galima nustatyti į ARGON2I rankiniu būdu). Tai apsaugo slaptažodžius nuo atakų, kurios bando atskleisti slaptažodžius iš duomenų bazės.</li>

<li>Duomenų bazės saugumas: Duomenų bazės užklausos yra paruoštos naudojant PDO paruoštas pareiškimus, kurie apsaugo nuo SQL injekcijos atakų.</li>
  </ul>
  Kuriamas papildinys <b></b>"Įvykių kalendorius"</b> tačiau jis dar 75% baigtumo
  <p>Prisijungimas prie sistemos: Demo User Name: Tester and password: 1234 , Projektas dar tęsiamas, numatoma pridėti daugiau funkcionalumų</p>
  
  /////// En /////////////////

  <h4> Flusity is a unique name that reflects the mission. It originated from the words "flussi" and "city", symbolizing the concepts of data flow and development, connecting everything into a harmonious "city" where everything moves freely and efficiently.</h4>
<p>PHP CMS project, Install, Log In, Sign Up, admin, moderator, user roles, add/edit/delete (post, layout places, language, files, menu, themes, custom block, addon (plugin) system, user,  backup.sql), update website settings, Integrated functionality allows for the addition of an extra language to be set as default from the list 'lt', 'it', 'fr', 'de', with 'en' as an additional option. With some skills, it's possible to reverse the settings.</p>
<p><b>CMS flusity</b>Flusity CMS</b> uses PHP as its main server-side programming language.<p>
 <p>CMS flusity uses a traditional server-side generation model, but is built with modern technology and best practices.</p>

<p>The project uses a MySQL database.</p>
<p>This project uses Bootstrap - one of the most popular front-end frameworks.</p>
<p>Also uses jQuery, which is an easy-to-use and flexible JavaScript library for efficient DOM manipulation and AJAX requests.</p>
<p>Like most websites, Flusity-CMS uses HTML and CSS to structure and style the website.</p>
<p>The project also uses Model-View-Controller (MVC) architecture, which helps keep the code neat and well-organized.</p>
<p>The implementation of prefix support allows for more efficient database management as it creates a clear structure and helps avoid naming conflicts, especially when the same CMS is used for various websites or when various plugins and modules are included. This is particularly beneficial in large systems and aids in enhancing security and data organization.</p>
<br>
<b>This site admin control panel includes the following features:</b>
  <h3>Dashboard</h3>
<ul><li>
<li>Dashboard (information summary)</li>
<li>Users</li>
<li>Places // "These are places in the parts of the page where block info can be presented"</li>
<li>Posts</li>
<li>Menu</li>
<li>Addons</li>
<li>Block</li>
 <li>Tags</li>
<li>Contact Form</li>
<li>Files</li>
<li>Language (default en)</li>
<li>Settings</li>
<li>Database backup</li>
<li>SEO (description keywords system)</li>
 <li>Themes</li>
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

<li>Password security: Passwords are stored using the password_hash() function, which uses a strong encryption algorithm (PASSWORD_BCRYPT or can be set to ARGON2I manually). This protects passwords from attacks that attempt to reveal passwords from the database.</li>

<li>Database security: Database queries are prepared using PDO prepared statements that protect against SQL injection attacks.</li>
   </ul>
   <p>Login to system user:  Demo User Name: Tester and password: 1234 ,The project is still ongoing, it is planned to add more functionalities</p>
   <br>
   <p>The <b>"event calendar"</b> plugin is being developed, but it is still 75% complete</p>
Author's address https://www.flusity.com
 
Autoriaus adresas https://www.flusity.com
<p>Admin dashboard</p>
<img src="https://flusity.com/uploads/admin_904cf16d5a6da047.jpg" width=40%/>
<p>Website settings</p>
<img src="https://flusity.com/uploads/setings_045559783520e60e.jpg" width=40%/>




