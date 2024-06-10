<?php session_start();
include("conn.php");
include("header.php");
if(!$_SESSION['id']){
?>
<script>
window.location.href = "index.php";
</script>
<?php
}
?>
<?php
if(isset($_POST['b_apply'])) {
    $lco=$_POST['lco'];
    $lco_email=$_POST['lco_email'];
    $n_name=$_POST['n_name'];
    $lconame=$_POST['lconame'];
    $lcophone=$_POST['lcophone'];
    $lcoaddress=$_POST['lcoaddress'];
    $lcoarea=$_POST['lcoarea'];
    $lcopincode=$_POST['lcopincode'];
    $r_address=$_POST['r_address'];
    $r_area=$_POST['r_area'];
    $r_pincode=$_POST['r_pincode'];
    $aadhar=$_POST['aadhar'];
    $pan=$_POST['pan'];
    $isp=$_POST['isp'];
    $customer=$_POST['customer'];
    $feed=$_POST['feed'];
    $amount=$_POST['amount'];
    $hub=$_POST['hub'];
    $compliance=$_POST['compliance'];
    $document=$_POST['document'];
    $status=$_POST['status'];
    $date=date('d-M-y');
    $flag="1";
    $target_dir="uploads/";
    $document = basename($_FILES["document"]["name"]);
    if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_dir.$document)) {
        $sql="INSERT INTO `application` (`date`,`applicant`,`lco_type`, `lco_email`, `company_name`, `lco_name`, `lco_contact`, `lco_address`, `lco_area`, `lco_pincode`, `lco_residence_address`, `lco_residence_area`, `lco_residence_pincode`, `lco_aadhar`, `lco_pan`, `isp_signal`, `customar_num`, `multi_feed`, `amount`, `nearest_hub`, `compliance`, `document`, `lco_status`,`flag`) VALUES ('{$date}','{$_SESSION['assign']}','{$lco}','{$lco_email}','{$n_name}','{$lconame}','{$lcophone}','{$lcoaddress}','{$lcoarea}','{$lcopincode}','{$r_address}','{$r_area}','{$r_pincode}','{$aadhar}','{$pan}','{$isp}','{$customer}','{$feed}','{$amount}','{$hub}','{$compliance}','{$document}','{$status}','{$flag}')";
        $query=mysqli_query($conn,$sql);
    }
?>
<script>
window.location.href = "application.php";
</script>
<?php
}
?>
<html>

<body>
    <div class="band1 w-100 mt-2" style="z-index: -1;">
        <img src="https://tasktracker.in/app/assets/img/icons/band.png" class="dash-img">
        <h4 class="aemp">BroadBand Application Form</h4>
    </div>
    <div class="container p-3">
        <div class="border border-3 smooth p-3" style="background-color: #fd9292;">
            <form class="p-3" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col-md-3 mt-1">
                        <label class="form-label ms-2"><strong>LCO Types</strong></label></br>
                        <input type="radio" class="btn-check form-control" name="lco" id="n_lco" value="New"
                            autocomplete="off">
                        <label class="btn btn-outline-success" for="n_lco">New LCO</label>

                        <input type="radio" class="btn-check form-control" name="lco" id="o_lco" value="Old"
                            autocomplete="off">
                        <label class="btn btn-outline-primary ms-3" for="o_lco">Old LCO</label>
                    </div>
                    <div class="col-md-4 mt-1">
                        <label for="inputEmail4" class="form-label ms-2"><strong>LCO Email</strong></label>
                        <input type="email" name="lco_email" class="form-control" id="inputEmail4" autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-5 mt-1">
                        <label for="name" class="form-label ms-2"><strong>Name Of the
                                Company/Network/Firm</strong></label>
                        <input type="text" name="n_name" class="form-control" aria-label="Name" id="name"
                            autocomplete="off" required>
                    </div>

                    <div class="col-md-3 mt-1">
                        <label for="lconame" class="form-label ms-2"><strong>LCO Name</strong></label>
                        <input type="text" name="lconame" class="form-control" id="lconame" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="lcophone" class="form-label ms-2"><strong>LCO Contact Number</strong></label>
                        <input type="text" name="lcophone" class="form-control" id="lcophone" autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-6 mt-1">
                        <label for="address" class="form-label ms-2"><strong>LCO Address</strong></label>
                        <input type="text" name="lcoaddress" class="form-control" id="address" autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="area" class="form-label ms-2"><strong>LCO Area</strong></label>
                        <input type="text" name="lcoarea" class="form-control" id="area" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="pincode" class="form-label ms-2"><strong>LCO Pincode</strong></label>
                        <input type="text" name="lcopincode" class="form-control" id="pincode" autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-6 mt-1">
                        <label for="raddress" class="form-label ms-2"><strong>LCO's Residence Address</strong></label>
                        <input type="text" name="r_address" class="form-control" id="raddress" autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="rarea" class="form-label ms-2"><strong>LCO's Residence Area</strong></label>
                        <input type="text" name="r_area" class="form-control" id="rarea" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="rpincode" class="form-label ms-2"><strong>LCO's Residence Pincode</strong></label>
                        <input type="text" name="r_pincode" class="form-control" id="rpincode" autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="aadhar" class="form-label ms-2"><strong>LCO Aadhar Number</strong></label>
                        <input type="text" name="aadhar" class="form-control" id="aadhar" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="pan" class="form-label ms-2"><strong>LCO PAN Number</strong></label>
                        <input type="text" name="pan" class="form-control" id="pan" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="isp" class="form-label ms-2"><strong>Present ISP Signal</strong></label>
                        <input type="text" name="isp" class="form-control" id="isp" autocomplete="off" required>
                    </div>
                    <div class="col-md-4 mt-1">
                        <label for="customer" class="form-label ms-2"><strong>Total Number Of Customers</strong></label>
                        <input type="text" name="customer" class="form-control" id="customer" autocomplete="off"
                            required>
                    </div>
                    <div class="col-md-2 mt-1">
                        <label class="form-label ms-2"><strong>Multiple Feed</strong></label></br>
                        <input type="radio" class="btn-check form-control" name="feed" id="yes" value="Yes"
                            autocomplete="off">
                        <label class="btn btn-outline-success" for="yes">Yes</label>

                        <input type="radio" class="btn-check form-control" name="feed" id="no" value="No"
                            autocomplete="off">
                        <label class="btn btn-outline-primary ms-3" for="no">No</label>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="amount" class="form-label ms-2"><strong>Installation Amount</strong></label>
                        <input type="text" name="amount" class="form-control" id="amount" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 mt-1">
                        <label for="hub" class="form-label ms-2"><strong>Nearest Hub</strong></label>
                        <input type="text" name="hub" class="form-control" id="hub" autocomplete="off" required>
                    </div>
                    <div class="col-md-4 mt-1">
                        <label class="form-label ms-2"><strong>Compliance</strong></label>
                        <select class="form-select" aria-label="Default select example" name="compliance" required>
                            <option></option>
                            <option value="Digital Agreement (On Email)">Digital Agreement (On Email)</option>
                            <option value="P & T License">P & T License</option>
                            <option value="Trade License">Trade License</option>
                            <option value="Aadhar">Aadhar</option>
                            <option value="PAN">PAN</option>
                            <option value="GST">GST</option>
                            <option value="P.P Photo">P.P Photo</option>
                            <option value="Stamp">Stamp</option>
                        </select>
                    </div>

                    <div class="col-md-5 mt-1">
                        <label class="form-label ms-2"><strong>LCO's Status</strong></label>
                        <select class="form-select" aria-label="Default select example" name="status" required>
                            <option></option>
                            <option value="Interested">Interested</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Follow Up Visit">Follow Up Visit</option>
                            <option value="Signed">Signed</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="File" class="form-label ms-2"><strong>Documentation</strong></label>
                        <input class="form-control" type="file" name="document" id="File" max-size="5000"
                            accept="image/png, image/jpeg, application/pdf">
                        <span class="notranslate ms-2" style="color:#FF5147;font-size:11px;">File format: .jpeg/ .png/
                            ./pdf
                            Max
                            file size limit: 5MB </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2" style="text-align: center;">
                        <input type="submit" name="b_apply" value="Submit" class="btn btn-outline-success m-2">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
    function validateForm() {
        var fileInput = document.getElementById('File');

        // Check if a file is selected
        if (fileInput.files.length === 0) {
            alert('Please select a file before submitting the form.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
    </script>
</body>

</html>