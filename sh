warning: in the working copy of 'back-end/resources/views/admin/quizzes.blade.php', CRLF will be replaced by LF the next time Git touches it
[1mdiff --git a/back-end/resources/views/admin/quizzes.blade.php b/back-end/resources/views/admin/quizzes.blade.php[m
[1mindex f85c064..746c0ff 100644[m
[1m--- a/back-end/resources/views/admin/quizzes.blade.php[m
[1m+++ b/back-end/resources/views/admin/quizzes.blade.php[m
[36m@@ -306,27 +306,7 @@[m [mclass="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary[m
         </div>[m
 [m
         <div class="flex-1 overflow-auto">[m
[31m-         [m
[31m-            <!DOCTYPE html>[m
[31m-            <html lang="fr">[m
[31m-            <head>[m
[31m-                <meta charset="UTF-8">[m
[31m-                <meta name="viewport" content="width=device-width, initial-scale=1.0">[m
[31m-                <title>Gestion des Quiz</title>[m
[31m-                <script src="https://cdn.tailwindcss.com"></script>[m
[31m-                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">[m
[31m-            </head>[m
[31m-            <body class="bg-gray-50">[m
[31m-                <div class="flex-1 overflow-auto">[m
[31m-                    <header class="bg-[#4D44B5] text-white shadow-md">[m
[31m-                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">[m
[31m-                            <h1 class="text-2xl font-bold">QuizMaster Pro</h1>[m
[31m-                            <button id="newQuizBtn"[m
[31m-                                class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">[m
[31m-                                <i class="fas fa-plus mr-2"></i> Nouveau Quiz[m
[31m-                            </button>[m
[31m-                        </div>[m
[31m-                    </header>[m
[32m+[m
             [m
                     <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">[m
                         @if(session('success'))[m
[36m@@ -484,6 +464,8 @@[m [mclass="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transitio[m
         });[m
     };[m
 });[m
[31m-                </script>[m
[32m+[m
[32m+[m
[32m+[m[32m      </script>[m
             </body>[m
             </html>[m
\ No newline at end of file[m
