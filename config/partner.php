<?php
 return [

     /*
    |--------------------------------------------------------------------------
    | Налаштування email
    |--------------------------------------------------------------------------
     */

    'email' => [
        'admin_email' => 'yura.voldiner@gmail.com',
        'warning_create_report_email' => 'service-vopas@ukr.net',
        'warning_create_invoice_email' => 'service-vopas@ukr.net',
    ],

     /*
   |--------------------------------------------------------------------------
   | директорія, куди завантажуються по FTP файли
   |--------------------------------------------------------------------------
    */
     'download_users_file' => storage_path('app/downloads/users.dbf'),
     'download_invoices_file' => 'invoices.dbf',
     'download_products_file' => 'products.dbf',
     'download_retentions_file' => 'retents.dbf',

     /*
    |--------------------------------------------------------------------------
    | параметри для формування сторінки reports
    |--------------------------------------------------------------------------
    */
     'reports_to_page' => 8,    // кількість на одну сторінку
     'last_reports_to_view' => 20,     // скільки останніх записів відображати при відсутності умов відбору
     /*
     |--------------------------------------------------------------------------
     | параметри для формування сторінки invoices
     |--------------------------------------------------------------------------
     */
     'invoices_to_page' => 8,    // кількість на одну сторінку
     'last_invoices_to_view' => 20,     // скільки останніх записів відображати при відсутності умов відбору
 ];