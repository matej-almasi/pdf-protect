# PDF Protect

A simple [WooCommerce](https://woocommerce.com/) plugin for embedding a Data
Rights notice customized with customer details in purchased PDFs.

## How to

As this is a simple plugin, you will need to follow a few steps to make it
work.

### 1. Grab a .ttf font

Download a TrueType font of your liking, for example from
[Google Fonts](https://fonts.google.com/). Once done, upload the font as a
multimedia file:

![media_upload](https://github.com/user-attachments/assets/4e16c249-2c9a-4fe7-b917-5eb272bb88ae)

Then, write down the upload path of the font from `/wp-content/uploads/`.
For example, for the following uploaded font:

![upload_path](https://github.com/user-attachments/assets/3cae05e6-61e4-4895-a661-6cee304a1de0)

it would be: **2025/03/**

### 2. Install the plugin

Download the zip from the [latest release](https://github.com/matej-almasi/pdf-protect/releases/tag/v1.0.0)
and install it as you would any other WordPress plugin.

### 3. Update the path to the font and font name

The source PHP scripts need to be updated to match your preferred font, as
well as your shop name and support email. Head to plugin file editor:

![plugin_editor](https://github.com/user-attachments/assets/f031f39c-e2e6-4e10-af71-09d30a147fb8)

then, select the **PDF Protect** plugin from the "Select plugin to edit:" dropdown:

![plugin_select](https://github.com/user-attachments/assets/bb898311-e527-43d5-9495-eb3702356a09)

next, head to `includes/serve-protected-pdf.php`:

![serve-protected-pdf](https://github.com/user-attachments/assets/fb2e49da-d892-4f53-8a5f-145704a4f714)

and edit the following `TODO:`s, with the upload path and font name:

![edit_year_month](https://github.com/user-attachments/assets/2470f131-a959-4661-bdda-014e8a44e2dd)

![edit_font_name](https://github.com/user-attachments/assets/83057db8-d4c4-4e94-8d1e-d4c094fe21ec)

### 4. Update your shop's name and support email

Head to `includes/generate-data-rights.php`:

![generate-data-rights](https://github.com/user-attachments/assets/277ca903-ca61-4649-b813-c2a69f56cbe9)

and edit the `$shop_name` and `$support_email` variables with your shop name and support email:

![data_rights_edit](https://github.com/user-attachments/assets/7fd7465f-3711-48d7-a9d6-25804794e739)

You may also edit the data rights wording as you like.

Then, head over to `includes/pdf-protect.php`:

![pdf_protect](https://github.com/user-attachments/assets/3d96e57b-e26e-4fca-8727-84127c59f930)

and edit the log email recipients. This address will be used to send any
errors that occur during plugin execution.

![edit_log_recipients](https://github.com/user-attachments/assets/1d073630-2ee7-4e85-a43a-192171157aaf)

### 5. Activate the plugin

:tada: All is set up and you can activate the plugin!

## Reporting issues

In case of any problems with the plugin, don't hesitate to create a
[new issue](https://github.com/matej-almasi/pdf-protect/issues/new/choose).

## Licensing

Licnesed under the [GNU General Public License v3.0](/LICENSE.MD).
