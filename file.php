<?php
defined('_ASTEXE_') or die('No access');



if( isset($_COOKIE["how_get_omniva"]) )
{
	$how_get = json_decode($_COOKIE["how_get_omniva"], true);
}

    $all_fields_query = $db_link->prepare("SELECT * FROM omniva;");
	$all_fields_query->execute();
	$omniva_variants_query = $db_link->prepare("SELECT * FROM omniva  ORDER BY `region` ASC;");
	$omniva_variants_query->execute();
    $omniva_variant_record = $omniva_variants_query->fetch();
	$omniva_variants_query = $db_link->prepare("SELECT * FROM omniva ORDER BY `region` ASC;");
    $omniva_variants_query->execute();

?>

 <form action="" id="omnivaform" onsubmit="nextStep();" method="post">
        <input type="hidden" name="choose_omniva" />
        <div id="OmnivaSelector">
                <div class="panel panel-primary">
                    <div class="panel-heading">Choose your Omniva</div>
                    <div class="panel-body">
                          <div class="form-group">
                            <select id="omniva_variant_selector" class="form-control" />
                            <?php
                            while( $omniva_variant_record = $omniva_variants_query->fetch() )
                            :
                                ?>
                            <optgroup label="<?php echo $omniva_variant_record["region"]; ?>">
<option><?php echo $omniva_variant_record["name"]; ?></option>
                                                            </optgroup>
                                <?php
                            endwhile;
                            ?>
                            </select>
                            <?php echo var_dump ($omniva_variants_query->fetch()); ?>
                          </div>
                    </div>
                </div>

        </div>
        </script>
    </form>

<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/content/users/users_agreement_module.php");
?>

<div class="text-center">
	<a class="btn btn-ar btn-primary" href="javascript:void(0);" onclick="nextStep();">Continue</a>
</div>

<script>
function nextStep()
{
	if( !check_user_agreement() )
	{
		return;
	}
	
    var how_get = new Object;
		how_get.mode = <?php echo $current_obtain_mode; ?>;
		how_get.city = encodeURIComponent(document.getElementById("omniva_variant_selector").value);

	
    var date = new Date(new Date().getTime() + 15552000 * 1000);
    document.cookie = "how_get="+JSON.stringify(how_get)+"; path=/; expires=" + date.toUTCString();
	
    document.cookie = "how_get_omniva="+JSON.stringify(how_get)+"; path=/; expires=" + date.toUTCString();

	location = "/shop/checkout/confirm";
}
</script>
