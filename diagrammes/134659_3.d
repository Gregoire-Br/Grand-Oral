format 224

classinstance 128002 class_ref 128002 // Candidat
  name ""   xyz 13.5 4.1 2000 life_line_z 2000
classinstance 128130 class_ref 128130 // Enseignants
  name ""   xyz 124.18 4.1 2000 life_line_z 2000
classinstance 128258 class_ref 128258 // ProviseurAdjoint
  name ""   xyz 268.92 4.1 2000 life_line_z 2000
classinstance 128386 class_ref 135042 // Site
  name ""   xyz 588.98 6.8 2000 life_line_z 2000
classinstance 128514 class_ref 128131 // BDD
  name ""   xyz 771.6 4.2 2000 life_line_z 2000
durationcanvas 128003 classinstance_ref 128002 // :Candidat
  xyzwh 45 75.4 2010 11 485
end
durationcanvas 128131 classinstance_ref 128386 // :Site
  xyzwh 607 83.8 2010 11 142
  overlappingdurationcanvas 128515
    xyzwh 613 134.4 2020 11 47
  end
  overlappingdurationcanvas 132611
    xyzwh 613 186.4 2020 11 33
  end
end
durationcanvas 128771 classinstance_ref 128514 // :BDD
  xyzwh 793 146.8 2010 11 37
end
durationcanvas 129027 classinstance_ref 128130 // :Enseignants
  xyzwh 168 199.6 2010 11 248
end
durationcanvas 129667 classinstance_ref 128386 // :Site
  xyzwh 607 238 2010 11 155
  overlappingdurationcanvas 130435
    xyzwh 613 316.2 2020 11 71
  end
end
durationcanvas 130947 classinstance_ref 128514 // :BDD
  xyzwh 793 309.8 2010 11 140
end
durationcanvas 131331 classinstance_ref 128258 // :ProviseurAdjoint
  xyzwh 327 361.4 2010 11 164
end
durationcanvas 131587 classinstance_ref 128386 // :Site
  xyzwh 607 429.4 2010 11 137
  overlappingdurationcanvas 131971
    xyzwh 613 485.4 2020 11 75
  end
end
durationcanvas 132227 classinstance_ref 128514 // :BDD
  xyzwh 793 496.8 2010 11 27
end
msg 128259 synchronous
  from durationcanvas_ref 128003
  to durationcanvas_ref 128131
  yz 88 2015 explicitmsg "Authentification"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 241 69
msg 128387 return
  from durationcanvas_ref 128131
  to durationcanvas_ref 128003
  yz 124 2020 explicitmsg "Accès permis"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 247 105
msg 128643 synchronous
  from durationcanvas_ref 128003
  to durationcanvas_ref 128515
  yz 147 2025 explicitmsg "Renseignement de la fiche"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 203 128
msg 128899 synchronous
  from durationcanvas_ref 128515
  to durationcanvas_ref 128771
  yz 159 2030 explicitmsg "Nouvelles infos"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 633 138
msg 129795 synchronous
  from durationcanvas_ref 129027
  to durationcanvas_ref 129667
  yz 236 2015 explicitmsg "Authentification"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 301 217
msg 129923 return
  from durationcanvas_ref 129667
  to durationcanvas_ref 129027
  yz 269 2015 explicitmsg "Accès permis"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 307 250
msg 130563 synchronous
  from durationcanvas_ref 129027
  to durationcanvas_ref 130435
  yz 316 2025 explicitmsg "Validation"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 325 297
msg 131075 synchronous
  from durationcanvas_ref 130435
  to durationcanvas_ref 130947
  yz 317 2030 explicitmsg "enseigValid"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 653 298
msg 131459 return
  from durationcanvas_ref 130435
  to durationcanvas_ref 131331
  yz 375 2025 explicitmsg "Demande de validation par mail"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 367 355
msg 131715 synchronous
  from durationcanvas_ref 131331
  to durationcanvas_ref 131587
  yz 442 2015 explicitmsg "Authentification"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 392 423
msg 131843 return
  from durationcanvas_ref 131587
  to durationcanvas_ref 131331
  yz 472 2015 explicitmsg "Accès permis"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 398 452
msg 132099 synchronous
  from durationcanvas_ref 131331
  to durationcanvas_ref 131971
  yz 496 2025 explicitmsg "Validation"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 417 477
msg 132355 synchronous
  from durationcanvas_ref 131971
  to durationcanvas_ref 132227
  yz 499 2025 explicitmsg "provValid"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 650 480
msg 132483 return
  from durationcanvas_ref 131971
  to durationcanvas_ref 128003
  yz 551 2025 explicitmsg "Confirmation de validation"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 217 533
msg 132739 synchronous
  from durationcanvas_ref 128003
  to durationcanvas_ref 132611
  yz 184 2025 explicitmsg "Validation"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 301 166
msg 132867 return
  from durationcanvas_ref 132611
  to durationcanvas_ref 129027
  yz 204 3005 explicitmsg "Demande de validation par mail"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 277 190
end
