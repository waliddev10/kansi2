<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect('/home');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(
    function () {

        #--------------------------------------------------------------------
        # ROUTE USER
        #--------------------------------------------------------------------
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/upcoming-agenda', 'UpcomingAgendaController@index')->name('upcoming_agenda');
        Route::get('/agenda', 'AgendaController@index')->name('agenda');
        Route::get('/data/agenda', 'AgendaController@get')->name('agenda.get');

        Route::get('/agenda/{slug}', 'AgendaController@detail')->name('agenda_detail');
        Route::get('/agenda/present/{slug}', 'AgendaController@present_index')->name('agenda_detail.present');
        Route::post('/agenda/send-present', 'AgendaController@present_store')->name('agenda_detail.present.store');

        Route::get('/contact-us', 'InfoController@user_contact_index')->name('contact');

        Route::get('/forum', 'ForumController@index')->name('forum');


        Route::get('/notification', 'NotificationController@index')->name('notification');
        Route::get('/notification/{slug}', 'NotificationController@detail')->name('notification.detail');
        Route::get('/notification/unread/{id}', 'NotificationController@unread')->name('notification.unread');


        Route::get('/profile-settings', 'HomeController@profile_settings_index')->name('profile_settings');
        Route::post('/profile-settings/password-update', 'HomeController@profile_settings_password_update')->name('profile_settings.password.update');
        Route::put('/profile-settings/update', 'HomeController@profile_settings_update')->name('profile_settings.update');
        Route::get('/profile-settings/data', 'HomeController@profile_settings_get')->name('profile_settings.get');
        # END ROUTE USER ----------------------------------------------------

        #--------------------------------------------------------------------
        # ROUTE MODERATOR
        #--------------------------------------------------------------------
        Route::middleware(['auth.moderator'])->group(
            function () {
                # MASTER DATA POSITION/JABATAN -------------------------------
                Route::get('/user-list', 'UserController@index')->name('moderator.user_list');

                Route::get('/user-list/get', 'UserController@get')->name('moderator.user_list.get');
                Route::post('/user-list/store', 'UserController@store')->name('moderator.user_list.store');
                Route::put('/user-list/update', 'UserController@update')->name('moderator.user_list.update');
                Route::delete('/user-list/delete', 'UserController@destroy')->name('moderator.user_list.delete');

                Route::delete('/user-list/destroy', 'UserController@destroy_permanent')->name('moderator.user_list.destroy');
                Route::put('/user-list/restore', 'UserController@restore')->name('moderator.user_list.restore');

                Route::post('/user-list/data', 'UserController@datatable')->name('moderator.user_list.datatable');
                Route::post('/user-list/data/trash', 'UserController@datatable_trash')->name('moderator.user_list.datatable_trash');
                #-------------------------------- jangan diutik-utik plis ----

                Route::get('/moderator/agenda', 'AgendaController@moderator_agenda_index')->name('moderator.agenda');
                Route::get('/moderator/agenda/get', 'AgendaController@moderator_agenda_get')->name('moderator.agenda.get');
                Route::post('/moderator/agenda/store', 'AgendaController@moderator_agenda_store')->name('moderator.agenda.store');
                Route::put('/moderator/agenda', 'AgendaController@moderator_agenda_update')->name('moderator.agenda.update');
                Route::delete('/moderator/agenda/delete', 'AgendaController@moderator_agenda_destroy')->name('moderator.agenda.delete');

                Route::delete('/moderator/agenda/destroy', 'AgendaController@moderator_agenda_destroy_permanent')->name('moderator.agenda.destroy');
                Route::put('/moderator/agenda/restore', 'AgendaController@moderator_agenda_restore')->name('moderator.agenda.restore');

                Route::post('/moderator/agenda/data', 'AgendaController@moderator_agenda_datatable')->name('moderator.agenda.data');
                Route::post('/moderator/agenda/data/trash', 'AgendaController@moderator_agenda_datatable_trash')->name('moderator.agenda.data_trash');


                Route::get('/moderator/notification', 'NotificationController@moderator_notification_index')->name('moderator.notification');
                Route::get('/moderator/notification/get', 'NotificationController@moderator_notification_get')->name('moderator.notification.get');
                Route::post('/moderator/notification/store', 'NotificationController@moderator_notification_store')->name('moderator.notification.store');
                Route::put('/moderator/notification', 'NotificationController@moderator_notification_update')->name('moderator.notification.update');
                Route::delete('/moderator/notification/delete', 'NotificationController@moderator_notification_destroy')->name('moderator.notification.delete');

                Route::delete('/moderator/notification/destroy', 'NotificationController@moderator_notification_destroy_permanent')->name('moderator.notification.destroy');
                Route::put('/moderator/notification/restore', 'NotificationController@moderator_notification_restore')->name('moderator.notification.restore');

                Route::post('/moderator/notification/data', 'NotificationController@moderator_notification_datatable')->name('moderator.notification.data');
                Route::post('/moderator/notification/data/trash', 'NotificationController@moderator_notification_datatable_trash')->name('moderator.notification.data_trash');
            }
        );
        # END ROUTE MODERATOR -----------------------------------------------

        #--------------------------------------------------------------------
        # ROUTE ADMIN GALAK
        #--------------------------------------------------------------------
        Route::middleware(['auth.admin'])->group(
            function () {
                Route::get('/admin/application-info', 'InfoController@index')->name('application_info');

                #---- route list moderator & admin
                Route::get('/admin/moderator-list', 'ModeratorAdminController@index')->name('moderator_list');
                Route::put('/admin/moderator-list/update', 'ModeratorAdminController@update')->name('moderator_list.update');

                Route::get('/admin/admin-list', 'ModeratorAdminController@admin_index')->name('admin_list');
                Route::put('/admin/admin-list/update', 'ModeratorAdminController@admin_update')->name('admin_list.update');

                Route::post('/admin/moderator-list/data', 'ModeratorAdminController@datatable_moderator')->name('moderator_list.datatable');
                Route::post('/admin/user-list/data', 'ModeratorAdminController@datatable_user')->name('user_list.datatable');
                Route::post('/admin/admin-list/data', 'ModeratorAdminController@datatable_admin')->name('admin_list.datatable');
                #---- route list moderator & admin

                #---- route master
                Route::group(
                    ['prefix' => 'admin/master'],
                    function () {
                        # MASTER DATA POSITION/JABATAN -------------------------------
                        Route::get('/position', 'PositionController@index')->name('master_position');

                        Route::get('/position/get', 'PositionController@get')->name('master_position.get');
                        Route::post('/position/store', 'PositionController@store')->name('master_position.store');
                        Route::put('/position/update', 'PositionController@update')->name('master_position.update');
                        Route::delete('/position/delete', 'PositionController@destroy')->name('master_position.destroy');

                        Route::delete('/position/destroy', 'PositionController@destroy_permanent')->name('master_position.destroy_permanent');
                        Route::put('/position/restore', 'PositionController@restore')->name('master_position.restore');

                        Route::post('/position/data', 'PositionController@datatable')->name('datatable_position');
                        Route::post('/position/data/trash', 'PositionController@datatable_trash')->name('datatable_trash_position');
                        #-------------------------------- jangan diutik-utik plis ----

                        # MASTER DATA WORKUNIT/SATUAN KERJA --------------------------
                        Route::get('/workunit', 'WorkunitController@index')->name('master_workunit');

                        Route::get('/workunit/get', 'WorkunitController@get')->name('master_workunit.get');
                        Route::post('/workunit/store', 'WorkunitController@store')->name('master_workunit.store');
                        Route::put('/workunit/update', 'WorkunitController@update')->name('master_workunit.update');
                        Route::delete('/workunit/delete', 'WorkunitController@destroy')->name('master_workunit.destroy');

                        Route::delete('/workunit/destroy', 'WorkunitController@destroy_permanent')->name('master_workunit.destroy_permanent');
                        Route::put('/workunit/restore', 'WorkunitController@restore')->name('master_workunit.restore');

                        Route::post('/workunit/data', 'WorkunitController@datatable')->name('datatable_workunit');
                        Route::post('/workunit/data/trash', 'WorkunitController@datatable_trash')->name('datatable_trash_workunit');
                        #-------------------------------- jangan diutik-utik plis ----

                        # MASTER DATA STATUS KEGIATAN --------------------------------
                        Route::get('/status-agenda', 'StatusAgendaController@index')->name('master_status_agenda');

                        Route::get('/status-agenda/get', 'StatusAgendaController@get')->name('master_status_agenda.get');
                        Route::post('/status-agenda/store', 'StatusAgendaController@store')->name('master_status_agenda.store');
                        Route::put('/status-agenda/update', 'StatusAgendaController@update')->name('master_status_agenda.update');
                        Route::delete('/status-agenda/delete', 'StatusAgendaController@destroy')->name('master_status_agenda.destroy');

                        Route::delete('/status-agenda/destroy', 'StatusAgendaController@destroy_permanent')->name('master_status_agenda.destroy_permanent');
                        Route::put('/status-agenda/restore', 'StatusAgendaController@restore')->name('master_status_agenda.restore');

                        Route::post('/status-agenda/data', 'StatusAgendaController@datatable')->name('datatable_status_agenda');
                        Route::post('/status-agenda/data/trash', 'StatusAgendaController@datatable_trash')->name('datatable_trash_status_agenda');
                        #-------------------------------- jangan diutik-utik plis ----

                        # MASTER DATA STATUS KEGIATAN --------------------------------
                        Route::get('/contact', 'InfoController@contact_index')->name('master_contact');

                        Route::get('/contact/get', 'InfoController@contact_get')->name('master_contact.get');
                        Route::post('/contact/store', 'InfoController@contact_store')->name('master_contact.store');
                        Route::put('/contact', 'InfoController@contact_update')->name('master_contact.update');
                        Route::delete('/contact/delete', 'InfoController@contact_destroy')->name('master_contact.destroy');

                        Route::delete('/contact/destroy', 'InfoController@contact_destroy_permanent')->name('master_contact.destroy_permanent');
                        Route::put('/contact/restore', 'InfoController@contact_restore')->name('master_contact.restore');

                        Route::post('/contact/data', 'InfoController@contact_datatable')->name('datatable_contact');
                        Route::post('/contact/data/trash', 'InfoController@contact_datatable_trash')->name('datatable_trash_contact');
                        #-------------------------------- jangan diutik-utik plis ----
                    }
                );
                #---- route master
            }
        );
        # END ROUTE ADMIN ---------------------------------------------------
    }
);
