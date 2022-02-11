format 224

classinstance 128002 class_ref 128002 // Candidat
  name ""   xyz 13.5 4.1 2000 life_line_z 2000
classinstance 128130 class_ref 128130 // Enseignants
  name ""   xyz 124.74 4.1 2000 life_line_z 2000
classinstance 128258 class_ref 128258 // ProviseurAdjoint
  name ""   xyz 268.96 4.1 2000 life_line_z 2000
classinstance 128386 class_ref 135042 // Site
  name ""   xyz 518.94 4.22 2000 life_line_z 2000
classinstance 128514 class_ref 135170 // Etablissement
  name ""   xyz 642.2 4.22 2000 life_line_z 2000
durationcanvas 128642 classinstance_ref 128002 // :Candidat
  xyzwh 45 87.36 2010 11 436
end
durationcanvas 128770 classinstance_ref 128386 // :Site
  xyzwh 537 80.28 2010 11 25
end
durationcanvas 129026 classinstance_ref 128514 // :Etablissement
  xyzwh 695 141.24 2010 11 392
  overlappingdurationcanvas 129794
    xyzwh 701 294.4 2020 11 234
    overlappingdurationcanvas 130946
      xyzwh 707 449.9 2030 11 72
    end
  end
end
durationcanvas 129282 classinstance_ref 128130 // :Enseignants
  xyzwh 168 192.2 2010 11 177
end
durationcanvas 129538 classinstance_ref 128386 // :Site
  xyzwh 537 252.76 2010 11 25
end
durationcanvas 130050 classinstance_ref 128258 // :ProviseurAdjoint
  xyzwh 327 349.08 2010 11 127
end
durationcanvas 130690 classinstance_ref 128386 // :Site
  xyzwh 537 403.1 2010 11 25
end
durationcanvas 131202 classinstance_ref 128002 // :Candidat
  xyzwh 45 511.82 2010 11 25
end
msg 128898 synchronous
  from durationcanvas_ref 128642
  to durationcanvas_ref 128770
  yz 87 2015 explicitmsg "1 : s'authentifier"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 375 67
msg 129154 synchronous
  from durationcanvas_ref 128642
  to durationcanvas_ref 129026
  yz 147 2015 explicitmsg "2 : renseigner fiche"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 360 128
msg 129410 return
  from durationcanvas_ref 129026
  to durationcanvas_ref 129282
  yz 192 2015 explicitmsg "2.1 : demande de validation"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 341 175
msg 129666 synchronous
  from durationcanvas_ref 129282
  to durationcanvas_ref 129538
  yz 252 2015 explicitmsg "3 : s'authentifier"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 376 234
msg 129922 synchronous
  from durationcanvas_ref 129282
  to durationcanvas_ref 129794
  yz 294 2025 explicitmsg "4: valider fiche"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 390 277
msg 130178 return
  from durationcanvas_ref 129794
  to durationcanvas_ref 130050
  yz 352 2025 explicitmsg "4.1 : demande de validation"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 351 336
msg 130818 synchronous
  from durationcanvas_ref 130050
  to durationcanvas_ref 130690
  yz 406 2015 explicitmsg "5 : s'authentifier"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 382 389
msg 131074 synchronous
  from durationcanvas_ref 130050
  to durationcanvas_ref 130946
  yz 450 2035 explicitmsg "6 : valider fiche"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 405 432
msg 131330 return
  from durationcanvas_ref 130946
  to durationcanvas_ref 131202
  yz 511 2035 explicitmsg "6.1 confirmation validation"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 349 496
end
