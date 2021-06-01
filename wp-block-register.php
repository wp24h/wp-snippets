<?php

// Impedir o registro do usuário no wordpress de um domínio específico
function wp24h_disable_email_domain ( $errors, $sanitized_user_login, $user_email ) {
    list( $email_user, $email_domain ) = explode( '@', $user_email );
    if ( $email_domain == 'domain.com' ) {
        $errors->add( 'email_error', __( '<strong>ERROR</strong>: Domain not allowed.', 'my_domain' ) );
    }
    return $errors;
}
add_filter( 'registration_errors', 'wp24h_disable_email_domain', 10, 3 );

//funcção para obter TLDs
function getTld($domain){
	 	 $tld = substr($domain, strpos($domain, '.') + 1);
	 	 return  explode('.', $tld);
}

// Impedir o registro do usuário no wordpress de um TLD específico
function wp24h_disable_email_tlds ( $errors, $sanitized_user_login, $user_email ) {
    list( $email_user, $email_domain ) = explode( '@', $user_email );
    $tlds = getTld($email_domain);
    if (in_array('ru',$arr) ) { //dominios da Rússia, por exemplo
        $errors->add( 'email_error', '<strong>ERROR</strong>: Domain not allowed.' );
    }
    return $errors;
}
add_filter( 'registration_errors', 'wp24h_disable_email_tlds', 10, 3 );

