<?php
$title = "addAddress";
include('session.php');
include('db.php');
include('head.php');
//include('top.php');

$info = true;
if ($user_id == 0) {
  header("Location: signup.php");
} else if (isset($_POST['foo'])) {
  $result = user_info($conn, $user_id, $_POST["firstName"], $_POST["lastName"], $_POST["company"], $_POST["street"], $_POST["city"], $_POST["country"], $_POST["postcode"], $_POST["telefone"]);
  header("Location: checkout.php");
}
$user_info = get_user_info($conn, $user_id);
include('top.php');
?>
<div class="addAddressContainer text-font-family text-color">
  <h1>My Addresses</h1>
  <form action="" method="post">
    <input hidden name="foo" value="bar">
    <div id="addAddress" class="">
      <div>
        <div class="eachrow">
          <label for="addressFirstNameNew" class="sr-only">First Name</label>
          <input type="text" value="<?= $user_info["firstName"] ?>" name="firstName" id="addressFirstNameNew" autocomplete="given-name" placeholder="First Name" class="form_input text-color-peachfuzz text-font-family">
        </div>
        <div class="eachrow">
          <label for="addressLastNameNew" class="sr-only">Last Name</label>
          <input type="text" value="<?= $user_info["lastName"] ?>" name="lastName" id="addressLastNameNew" autocomplete="family-name" placeholder="Last time" class="form_input text-color-peachfuzz text-font-family">
        </div>
        <div class="eachrow">
          <label for="addressCompanyNew" class="sr-only">Company</label>
          <input type="text" value="<?= $user_info["company"] ?>" name="company" id="addressCompanyNew" autocomplete="organization" placeholder="Company" class="form_input text-color-peachfuzz text-font-family" >
        </div>
        <div class="eachrow">
          <label for="addressAddress1New" class="sr-only">Address</label>
          <input type="text" value="<?= $user_info["street"] ?>" name="street" id="addressAddress1New" autocomplete="address-line1" placeholder="Address 1" class="form_input text-color-peachfuzz text-font-family">
        </div>

        <div class="eachrow">
          <label for="addressCityNew" class="sr-only">City</label>
          <input type="text" value="<?= $user_info["city"] ?>" name="city" id="addressCityNew" autocomplete="address-level2" placeholder="City" class="form_input text-color-peachfuzzn text-font-family">
        </div>
        <div class="eachrow" style="display: none;">
          <label for="addressCountryNew" class="block text-left">Country</label>
          <select name="country" value="<?= $user_info["country"] ?>" id="addressCountryNew" data-default autocomplete="country" class="form_input text-color-peachfuzz text-font-family">
            <option value="United States">United States</option>
            <option value="Germany">Germany</option>
          </select>
        </div>
        <div class="eachrow">
          <label for="addressZipNew" class="sr-only">Zip</label>
          <input type="text" value="<?= $user_info["postcode"] ?>" name="postcode" id="addressZipNew" value="1" autocomplete="postal-code" placeholder="Zip" class="form_input text-color-peachfuzz text-font-family">
        </div>
        <div class="eachrow">
          <label for="addressPhoneNew" class="sr-only">Phone</label>
          <input type="text" value="<?= $user_info["telefone"] ?>" name="telefone" id="addressPhoneNew" autocomplete="tel" placeholder="Phone" class="form_input text-color-peachfuzz text-font-family">
        </div>
      </div>
      <div class="eachrow text-font-family gap-button">
        <button class="text-link text-font-family">
          Use Address
        </button>
        <button type="reset" class="text-link text-font-family">
          Reset
        </button>
      </div>
    </div>
  </form>
</div>
</div>

<?php include('footer.php') ?>