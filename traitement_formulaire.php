<!DOCTYPE HTML>
<html>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-60782226-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-60782226-2');
</script>

    <title>Traitement Formulaire - Bataillie Community Manager</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
    <script>
        document.body.className += ' fade-out';
    </script>
    <div class="page-wrap">

        <!-- Nav -->
        <nav id="nav">
            <ul>
                <li><a href="index.html"><span class="icon fa-home"></span></a></li>
                <li><a href="gallery.html"><span class="icon fa-camera-retro"></span></a></li>
                <li><a href="generic.html" class="active"><span class="icon fa-file-text-o"></span></a></li>
            </ul>
        </nav>

        <!-- Main -->
        <section id="main">

            <!-- Header -->
            <header id="header">
                <div>Bataillie Community Manager</div>
            </header>

            <!-- Section -->
            <section id="galleries">
                <div class="gallery">
                    <div class="column">
                        <h1>Contact via Formulaire</h1>
                        <?php
                    /*
                     ********************************************************************************************
                    CONFIGURATION
                     ********************************************************************************************
                     */
                    // destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
                    $destinataire = 'cyril.bataillie@gmail.com';
                    // copie ? (envoie une copie au visiteur)
                    $copie = 'oui'; // 'oui' ou 'non'
                    // Messages de confirmation du mail
                    $message_envoye = "Votre message nous est bien parvenu, merci de nous avoir contacté ! Suivez ce lien pour revenir à l'<a href=\"index.html\">accueil du site</a>";
                    $message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
                    // Messages d'erreur du formulaire
                    $message_erreur_formulaire = "Vous devez d'abord <a href=\"gallery.html\">envoyer le formulaire</a>.";
                    $message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";
                    /*
                     ********************************************************************************************
                    FIN DE LA CONFIGURATION
                     ********************************************************************************************
                     */
                    // on teste si le formulaire a été soumis
                    if (!isset($_POST['envoi']))
                    {
                        // formulaire non envoyé
                        echo '<p>'.$message_erreur_formulaire.'</p>'."\n";
                    }
                    else
                    {
                        /*
                         * cette fonction sert à nettoyer et enregistrer un texte
                         */
                        function Rec($text)
                        {
                            $text = htmlspecialchars(trim($text), ENT_QUOTES);
                            if (1 === get_magic_quotes_gpc())
                            {
                                $text = stripslashes($text);
                            }
                            $text = nl2br($text);
                            return $text;
                        };
                        /*
                         * Cette fonction sert à vérifier la syntaxe d'un email
                         */
                        function IsEmail($email)
                        {
                            $value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
                            return (($value === 0) || ($value === false)) ? false : true;
                        }
                        // formulaire envoyé, on récupère tous les champs.
                        $name     = (isset($_POST['name']))     ? Rec($_POST['name'])     : '';
                        $email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
                        $message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
                        // On va vérifier les variables et l'email ...
                        $email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré
                        if (($name != '') && ($email != '') && ($message != ''))
                        {
                            // les 4 variables sont remplies, on génère puis envoie le mail
                            $headers  = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'From:'.$name.' <'.$email.'>' . "\r\n" .
                                    'Reply-To:'.$email. "\r\n" .
                                    'Content-Type: text/HTML; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
                                    'Content-Disposition: inline'. "\r\n" .
                                    'Content-Transfer-Encoding: 7bit'." \r\n" .
                                    'X-Mailer:PHP/'.phpversion();
                            // envoyer une copie au visiteur ?
                            if ($copie == 'oui')
                            {
                                $cible = $destinataire.';'.$email.';';
                            }
                            else
                            {
                                $cible = $destinataire;
                            };
                            // Remplacement de certains caractères spéciaux
                            //$message = str_replace("&#039;","'",$message);
                            //$message = str_replace("&#8217;","'",$message);
                            //$message = str_replace("&quot;",'"',$message);
                            //$message = str_replace('<br>','',$message);
                            //$message = str_replace('<br />','',$message);
                            //$message = str_replace("&lt;","<",$message);
                            //$message = str_replace("&gt;",">",$message);
                            //$message = str_replace("&amp;","&",$message);
                            // Envoi du mail
                            $num_emails = 0;
                            $tmp = explode(';', $cible);
                            $corps = "<h1>Contact via <em>community-manager.bataillie.fr</em></h1>
                                      <p><strong>Nom : </strong>".$name."</p>
                                      <p><strong>Email : </strong>".$email."</p>
                                      <p><strong>Message : </strong><br/>".$message."</p>";
                            foreach($tmp as $email_destinataire)
                            {
                                if (mail($email_destinataire, "Contact via community-manager.bataillie.me", $corps, $headers))
                                    $num_emails++;
                            }
                            if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
                            {
                                echo '<p>'.$message_envoye.'</p>';
                            }
                            else
                            {
                                echo '<p>'.$message_non_envoye.'</p>';
                            };
                        }
                        else
                        {
                            // une des 3 variables (ou plus) est vide ...
                            echo '<p>'.$message_formulaire_invalide.' <a href="gallery.html">Retour au formulaire</a></p>'."\n";
                        };
                    }; // fin du if (!isset($_POST['envoi']))
                    ?>



                </div>
            </section>

            

            <!-- Footer -->
            <footer id="footer">
                <div class="copyright">
                    <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" style="text-decoration:none">Bataillie Community Manager 2018 - Creative Commons <i class="fa fa-creative-commons" aria-hidden="true"></i> BY-SA 4.0</a>
                </div>
            </footer>
        </section>
    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.poptrox.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/skel.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        function sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds) {
                    break;
                }
            }
        }
    </script>
</body>

<script>
    $(function() {
        $('body').removeClass('fade-out');
    });
</script>

</html>

