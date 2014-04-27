--TEST--
ldap_control_assertion() - Assertion control creation
--CREDITS--
Tiziano Müller <tiziano.mueller@stepping-stone.ch>
--SKIPIF--
<?php require_once('skipif.inc'); ?>
<?php require_once('skipifbindfailure.inc'); ?>
--FILE--
<?php
require "connect.inc";

$link = ldap_connect_and_bind($host, $port, $user, $passwd, $protocol_version);
insert_dummy_data($link);

$entry = array(
	"objectClass"	=> array(
		"top",
		"dcObject",
		"organization"),
	"dc"		=> "my-domain",
	"o"		=> "my-domain",
	"description"	=> "Domain description",
);

$control = ldap_control_session_tracking($link, "127.0.0.1", "localhost", LDAP_CONTROL_X_SESSION_TRACKING_USERNAME, "testuser");

var_dump(
	$control,
	ldap_modify($link, "dc=my-domain,dc=com", $entry, $control)
);

?>
===DONE===
--CLEAN--
<?php
require "connect.inc";

$link = ldap_connect_and_bind($host, $port, $user, $passwd, $protocol_version);

remove_dummy_data($link);
?>
--EXPECTF--
resource(%d) of type (ldap control)
bool(true)
===DONE===
