<?php 
function emailTemplate($name,$id,$greetings,$msg){
    $link = base_url(). '/user/activateAccount/'.$id;
    $year = date('Y');
return "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>

<head>
  
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='x-apple-disable-message-reformatting'>
    <!--[if !mso]><!-->
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <!--<![endif]-->
    <title></title>

    <!--[if !mso]><!-->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700&display=swap' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap' rel='stylesheet' type='text/css'>
    <!--<![endif]-->

    <style type='text/css'>
        table {
            font-family: 'Lato', sans-serif;
        }

        table,
        td {
            color: #000000;
        }

        a {
            color: #0000ee;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
             #logo {
                
                width: 100px;
            }
            #u_content_image_1 .v-container-padding-padding {
                padding: 30px 10px 10px !important;
            }

            #u_content_image_1 .v-src-width {
                width: 512px !important;
            }

            #u_content_image_1 .v-src-max-width {
                max-width: 66% !important;
            }

            #u_content_image_2 .v-src-width {
                width: 479px !important;
            }

            #u_content_image_2 .v-src-max-width {
                max-width: 55% !important;
            }

            #u_content_text_2 .v-container-padding-padding {
                padding: 15px 10px 35px !important;
            }
        }

        @media only screen and (min-width: 570px) {
            .u-row {
                width: 550px !important;
            }

            .u-row .u-col {
                vertical-align: top;
            }

            .u-row .u-col-100 {
                width: 550px !important;
            }

        }

        @media (max-width: 570px) {
             #logo {
                
                width: 100px;
            }
            .u-row-container {
                max-width: 100% !important;
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            .u-row .u-col {
                min-width: 320px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .u-row {
                width: calc(100% - 40px) !important;
            }

            .u-col {
                width: 100% !important;
            }

            .u-col>div {
                margin: 0 auto;
            }
        }

        body {
            margin: 0;
            padding: 0;
        }

        table,
        tr,
        td {
            vertical-align: top;
            border-collapse: collapse;
        }

        p {
            margin: 0;
        }

        .ie-container table,
        .mso-container table {
            table-layout: fixed;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors='true'] {
            color: inherit !important;
            text-decoration: none !important;
        }
    </style>




</head>

<body class='clean-body u_body' style='margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e0e5eb;color: #000000'>
    <!--[if IE]><div class='ie-container'><![endif]-->
    <!--[if mso]><div class='mso-container'><![endif]-->
    <table style='border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e0e5eb;width:100%' cellpadding='0' cellspacing='0'>
        <tbody>
            <tr style='vertical-align: top'>
                <td style='word-break: break-word;border-collapse: collapse !important;vertical-align: top'>
                    <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td align='center' style='background-color: #e0e5eb;'><![endif]-->


                    <div class='u-row-container' style='padding: 0px;background-color: transparent'>
                        <div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 550px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;'>
                            <div style='border-collapse: collapse;display: table;width: 100%;background-color: transparent;'>
                               
                                <div class='u-col u-col-100' style='max-width: 320px;min-width: 550px;display: table-cell;vertical-align: top;'>
                                    <div style='width: 100% !important;'>
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style='padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'>
                                            <!--<![endif]-->

                                            <table style='' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='v-container-padding-padding' style='overflow-wrap:break-word;word-break:break-word;padding:10px;' align='left'>

                                                            <table height='0px' align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'>
                                                                <tbody>
                                                                    <tr style='vertical-align: top'>
                                                                        <td style='word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'>
                                                                            <span>&#160;</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>



                    <div class='u-row-container' style='padding: 0px;background-color: transparent'>
                        <div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 550px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;'>
                            <div style='border-collapse: collapse;display: table;width: 100%;background-color: transparent;'>
                                
                                <div class='u-col u-col-100' style='max-width: 320px;min-width: 550px;display: table-cell;vertical-align: top;'>
                                    <div style='width: 100% !important;'>
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style='padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'>
                                            <!--<![endif]-->

                                            <table id='u_content_image_1' style='' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='v-container-padding-padding' style='overflow-wrap:break-word;word-break:break-word;padding:10px 10px 11px;' align='left'>

                                                            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                                                                <tr>
                                                                    <td style='padding-right: 0px;padding-left: 0px;' align='center'>

                                                                        <img align='center' border='0' src='https://dl.dropboxusercontent.com/s/o2gnx71t83j2k2s/image-2.png?dl=0' alt='Image' title='Image' style='outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none; id='logo'  />

                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>



                    <div class='u-row-container' style='padding: 0px;background-color: transparent'>
                        <div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 550px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #e96711;'>
                            <div style='border-collapse: collapse;display: table;width: 100%;background-color: transparent;'>
                               
                                <div class='u-col u-col-100' style='max-width: 320px;min-width: 550px;display: table-cell;vertical-align: top;'>
                                    <div style='width: 100% !important;'>
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style='padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'>
                                            <!--<![endif]-->

                                            <table style='' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='v-container-padding-padding' style='overflow-wrap:break-word;word-break:break-word;padding:23px 10px 10px;' align='left'>

                                                            <h1 style='margin: 0px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: book antiqua,palatino; font-size: 25px;'>
                                                                $greetings! <b>$name</b>
                                                            </h1>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table style='' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='v-container-padding-padding' style='overflow-wrap:break-word;word-break:break-word;padding:0px 10px 10px;' align='left'>

                                                            <h3 style='margin: 0px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal;  font-size: 18px;'>
                                                                $msg
                                                            </h3>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>



                    <div class='u-row-container' style='padding: 0px;background-color: transparent'>
                        <div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 550px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #e96711;'>
                            <div style='border-collapse: collapse;display: table;width: 100%;background-color: transparent;'>
                              
                                <div class='u-col u-col-100' style='max-width: 320px;min-width: 550px;display: table-cell;vertical-align: top;'>
                                    <div style='width: 100% !important;'>
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style='padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'>
                                            <!--<![endif]-->

                                            <table id='u_content_image_2' style='' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='v-container-padding-padding' style='overflow-wrap:break-word;word-break:break-word;padding:10px;' align='left'>

                                                            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                                                                <tr>
                                                                    <td style='padding-right: 0px;padding-left: 0px;' align='center'>

                                                                        <img align='center' border='0' src='https://dl.dropboxusercontent.com/s/184rsbovn6xxwme/image-1-min.jpeg?dl=0' alt='Image' title='Image' style='outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 39%;max-width: 206.7px;' width='206.7' class='v-src-width v-src-max-width' />

                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table id='u_content_text_2' style='' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='v-container-padding-padding' style='overflow-wrap:break-word;word-break:break-word;padding:15px 10px 35px;' align='left'>

                                                            <div style='color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word;'>
                                                                <p style='font-size: 14px; line-height: 140%;'><span style='font-size: 16px; line-height: 22.4px; font-family: Montserrat, sans-serif;'>Click the Button below to setup your new password</span></p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table style='' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='v-container-padding-padding' style='overflow-wrap:break-word;word-break:break-word;padding:20px 10px;' align='left'>

                                                            <div align='center'>
                                                            
                                                                <a href='$link' target='_blank' style='box-sizing: border-box;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #000000; background-color: #ffffff; border-radius: 5px;-webkit-border-radius: 5px; -moz-border-radius: 5px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;border-top-width: 1px; border-top-style: solid; border-top-color: #CCC; border-left-width: 1px; border-left-style: solid; border-left-color: #CCC; border-right-width: 1px; border-right-style: solid; border-right-color: #CCC; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #CCC;'>
                                                                    <span style='display:block;padding:10px 30px;line-height:120%;'><span style='font-size: 16px; line-height: 19.2px; font-family: Lato, sans-serif;'>Click Here</span></span>
                                                                </a>
                                                                <!--[if mso]></center></v:roundrect></td></tr></table><![endif]-->
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>



                    <div class='u-row-container' style='padding: 0px;background-color: transparent'>
                        <div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 550px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;'>
                            <div style='border-collapse: collapse;display: table;width: 100%;background-color: transparent;'>
                                
                                <div class='u-col u-col-100' style='max-width: 320px;min-width: 550px;display: table-cell;vertical-align: top;'>
                                    <div style='width: 100% !important;'>
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style='padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'>
                                            <!--<![endif]-->

                                            <table style='' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='v-container-padding-padding' style='overflow-wrap:break-word;word-break:break-word;padding:10px 10px 15px;' align='left'>

                                                            <div style='color: #7e8c8d; line-height: 140%; text-align: center; word-wrap: break-word;'>
                                                                <p style='font-size: 14px; line-height: 140%;'>&copy; $year Weight &amp; Measure Agency. All Rights Reserved.</p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>



                    <div class='u-row-container' style='padding: 0px;background-color: transparent'>
                        <div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 550px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;'>
                            <div style='border-collapse: collapse;display: table;width: 100%;background-color: transparent;'>
                               
                                <div class='u-col u-col-100' style='max-width: 320px;min-width: 550px;display: table-cell;vertical-align: top;'>
                                    <div style='width: 100% !important;'>
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style='padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'>
                                            <!--<![endif]-->

                                            <table style='' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='v-container-padding-padding' style='overflow-wrap:break-word;word-break:break-word;padding:10px;' align='left'>

                                                            <table height='0px' align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'>
                                                                <tbody>
                                                                    <tr style='vertical-align: top'>
                                                                        <td style='word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'>
                                                                            <span>&#160;</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>


                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if mso]></div><![endif]-->
    <!--[if IE]></div><![endif]-->
</body>

</html>

";
}

?>