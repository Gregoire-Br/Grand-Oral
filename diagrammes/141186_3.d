format 224

classinstance 128386 class_ref 141698 // UtilGénéral
  name ""   xyz 24.38 4.88 2000 life_line_z 2000
classinstance 128514 class_ref 135042 // Site
  name ""   xyz 406.52 13.14 2000 life_line_z 2000
classinstance 129154 class_ref 141826 // BDD
  name ""   xyz 594.88 13.24 2000 life_line_z 2000
fragment 129155 "alt"
  xyzwh 3.8 131.3 2020 831 425
  separator 8006
end
textcanvas 129411 "Valid == MDP correct"
  xyzwh 86.2 189.2 2025 151 55
textcanvas 130435 "Valid == MDP incorrect"
  xyzwh 73.2 401.8 2025 127 47
textcanvas 130691 "premConnexion == oui"
  xyzwh 74.8 287.2 3010 371 30
textcanvas 131331 "Vérif = utilisateur non existant"
  xyzwh 11.8 474.8 2025 167 51
textcanvas 131459 "Vérif = utilisateur existant"
  xyzwh 80.2 137.4 2030 173 41
fragment 131587 "opt"
  xyzwh 30.4 279.7 3005 413 100
end
fragment 131715 "alt"
  xyzwh 19.4 179.7 2020 801 287
  separator 7449
end
durationcanvas 128642 classinstance_ref 128386 // :UtilGénéral
  xyzwh 63 90.4 2010 11 455
end
durationcanvas 128770 classinstance_ref 128514 // :Site
  xyzwh 425 92.6 2010 11 452
end
durationcanvas 129282 classinstance_ref 129154 // :BDD
  xyzwh 616 91.4 2010 11 253
  overlappingdurationcanvas 129794
    xyzwh 622 102.8 2020 11 235
    overlappingdurationcanvas 128771
      xyzwh 628 149.8 2030 11 51
    end
    overlappingdurationcanvas 130819
      xyzwh 628 305.4 2030 11 25
    end
  end
end
msg 128898 synchronous
  from durationcanvas_ref 128642
  to durationcanvas_ref 128770
  yz 96 2015 explicitmsg "Authentification (entrée identifiant & mot de passe)"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 67 75
reflexivemsg 128899 synchronous
  to durationcanvas_ref 128771
  yz 149 2035 explicitmsg "Vérif. mot de passe"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 657 142
msg 129027 return
  from durationcanvas_ref 129794
  to durationcanvas_ref 128770
  yz 121 2025 explicitmsg "Vérif"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 513 107
msg 129410 synchronous
  from durationcanvas_ref 128770
  to durationcanvas_ref 129282
  yz 102 2020 explicitmsg "Requête SQL"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 487 85
msg 129667 return
  from durationcanvas_ref 128771
  to durationcanvas_ref 128770
  yz 153 2035 explicitmsg "Valid"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 513 135
msg 129795 return
  from durationcanvas_ref 128770
  to durationcanvas_ref 128642
  yz 206 2015 explicitmsg "Autorisation d'accès"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 257 189
reflexivemsg 129922 synchronous
  to durationcanvas_ref 129794
  yz 102 2025 explicitmsg "Vérification utilisateur"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 657 96
msg 130051 return
  from durationcanvas_ref 128770
  to durationcanvas_ref 128642
  yz 353 2015 explicitmsg "Demande de changement du mot de passe"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 91 333
msg 130179 return
  from durationcanvas_ref 128770
  to durationcanvas_ref 128642
  yz 414 2015 explicitmsg "Refus d'accès"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 288 397
reflexivemsg 130947 synchronous
  to durationcanvas_ref 130819
  yz 305 2035 explicitmsg "Première connexion?"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 659 298
msg 131075 return
  from durationcanvas_ref 130819
  to durationcanvas_ref 128770
  yz 306 3010 explicitmsg "premConnexion"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 467 287
msg 131203 return
  from durationcanvas_ref 128770
  to durationcanvas_ref 128642
  yz 515 2015 explicitmsg "Accès refusé"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 202 497
end
