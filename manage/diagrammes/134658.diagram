format 224

classinstance 128002 class_ref 128002 // Candidat
  name ""   xyz 41 10.4 2000 life_line_z 2000
classinstance 128130 class_ref 128514 // Jury
  name ""   xyz 248.9 6.4 2000 life_line_z 2000
classinstance 128258 class_ref 135170 // Etablissement
  name ""   xyz 418 10 2000 life_line_z 2000
durationcanvas 128131 classinstance_ref 128258 // :Etablissement
  xyzwh 471 72 2010 11 43
end
durationcanvas 128386 classinstance_ref 128002 // :Candidat
  xyzwh 73 66 2010 11 109
end
durationcanvas 128514 classinstance_ref 128130 // :Jury
  xyzwh 264 166 2010 11 79
end
durationcanvas 128770 classinstance_ref 128258 // :Etablissement
  xyzwh 471 180 2010 11 67
end
msg 128003 return
  from durationcanvas_ref 128770
  to durationcanvas_ref 128514
  yz 220 2015 explicitmsg "validation"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 323 201
msg 128259 synchronous
  from durationcanvas_ref 128386
  to durationcanvas_ref 128131
  yz 70 2015 explicitmsg "Génération fiche"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 221 53
msg 128387 return
  from durationcanvas_ref 128131
  to durationcanvas_ref 128386
  yz 97 2015 explicitmsg "fiche, avec INE en code QR"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 177 80
msg 128642 synchronous
  from durationcanvas_ref 128386
  to durationcanvas_ref 128514
  yz 167 2015 explicitmsg "Présentation code QR"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 90 145
msg 128898 synchronous
  from durationcanvas_ref 128514
  to durationcanvas_ref 128770
  yz 180 2015 explicitmsg "demande de validation"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 297 162
end
