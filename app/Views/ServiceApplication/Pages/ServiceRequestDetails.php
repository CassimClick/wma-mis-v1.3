<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.1/css/all.min.css" integrity="sha512-BxQjx52Ea/sanKjJ426PAhxQJ4BPfahiSb/ohtZ2Ipgrc5wyaTSgTwPhhZ/xC66vvg+N4qoDD1j0VcJAqBTjhQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url('ServiceApplication/css/landing.css') ?>">
    <title>WMA-OSA</title>
</head>

<body>
    <nav>
        <div class="logo">
            WMA-OSA
        </div>

    </nav>
    <section class="banner">
        <div class="overlay"></div>
        <div class="container">
            <div class="banner-text">
                <h2><?= $page->heading ?></h2>
            </div>
    </section>

    <div class="container">
        
       
        <div class="">
            <h4>REQUESTS FOR APPROVAL OF NEW MEASURES</h4>
            <h5>Requirements/Conditions:</h5>
            <p><b>To Process your Consent we will need the following Documents:</b></p>

            <ul style="list-style: none;margin:0;padding:0;">
                <li> <i class="fas fa-arrow-right"></i> Equipment Operation Manual including maintenance installation and testing </li>
                <li><i class="fas fa-arrow-right"></i> Information on sealing methods in places that are not visible and instructions for sealing/removal of seals, </li>
                <li><i class="fas fa-arrow-right"></i> Certificate of Incorporation. </li>


            </ul>

            <p><b>Note:</b> During the design approval process, we examine the design of the measuring instrument and will perform a physical inspection of the instrument on site or in the Laboratory.</p>
        </div>
        

        <a href="<?= base_url('service-request/login') ?>" class="button">Apply Now</a>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">Weights And Measure Agency &copy; <?= date('Y') ?></p>
                </div>

            </div>
        </div>
    </footer>
</body>

</html>