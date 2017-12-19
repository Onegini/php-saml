<?php

$settings = array(
    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them to be signed or encrypted.
    // Also it will reject the messages if the SAML standard is not strictly
    // followed: Destination, NameId, Conditions ... are validated too.
    'strict' => false,

    // Enable debug mode (to print errors).
    'debug' => true,

    // Set a BaseURL to be used instead of try to guess
    // the BaseURL of the view that process the SAML Message.
    // Ex http://sp.example.com/
    //    http://example.com/sp/
    'baseurl' => 'http://127.0.0.1:8080',

    // Service Provider Data that we are deploying.
    'sp' => array(
        // Identifier of the SP entity  (must be a URI)
        'entityId' => 'http://127.0.0.1:8080/testPHP',
        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService' => array(
            // URL Location where the <Response> from the IdP will be returned
            'url' => 'http://127.0.0.1:8080/consume.php',
            // SAML protocol binding to be used when returning the <Response>
            // message. OneLogin Toolkit supports this endpoint for the
            // HTTP-POST binding only.
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ),
        // If you need to specify requested attributes, set a
        // attributeConsumingService. nameFormat, attributeValue and
        // friendlyName can be omitted
        "attributeConsumingService" => array(
            "serviceName" => "SP test",
            "serviceDescription" => "Test Service",
            "requestedAttributes" => array(
                array(
                    "name" => "",
                    "isRequired" => false,
                    "nameFormat" => "",
                    "friendlyName" => "",
                    "attributeValue" => ""
                )
            )
        ),
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        'singleLogoutService' => array(
            // URL Location where the <Response> from the IdP will be returned
            'url' => 'http://127.0.0.1:8080/sls.php',
            // SAML protocol binding to be used when returning the <Response>
            // message. OneLogin Toolkit supports the HTTP-Redirect binding
            // only for this endpoint.
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // Specifies the constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported.
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        // Usually x509cert and privateKey of the SP are provided by files placed at
        // the certs folder. But we can also provide them with the following parameters
        'x.509cert' => '',
        'privateKey' => '',

        /*
         * Key rollover
         * If you plan to update the SP x509cert and privateKey
         * you can define here the new x509cert and it will be
         * published on the SP metadata so Identity Providers can
         * read them and get ready for rollover.
         */
        // 'x509certNew' => '',
    ),

    // Identity Provider Data that we want connected with our SP.
    'idp' => array(
        // Identifier of the IdP entity  (must be a URI)
        'entityId' => 'https://consultancy-cim.onegini.com',
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => array(
            // URL Target of the IdP where the Authentication Request Message
            // will be sent.
            'url' => 'https://consultancy-cim.onegini.com/saml/single-sign-on',
            // SAML protocol binding to be used when returning the <Response>
            // message. OneLogin Toolkit supports the HTTP-Redirect binding
            // only for this endpoint.
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // SLO endpoint info of the IdP.
        'singleLogoutService' => array(
            // URL Location of the IdP where SLO Request will be sent.
            'url' => 'https://consultancy-cim.onegini.com/saml/single-logout',
            // SAML protocol binding to be used when returning the <Response>
            // message. OneLogin Toolkit supports the HTTP-Redirect binding
            // only for this endpoint.
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // Public x509 certificate of the IdP
        'x509cert' => "MIIDmDCCAoACCQC1yJJAA/4CcDANBgkqhkiG9w0BAQUFADCBjTELMAkGA1UEBhMCTkwxEDAOBgNVBAgTB1V0cmVjaHQxEDAOBgNVBAcTB1dvZXJkZW4xFTATBgNVBAoTDE9uZWdpbmkgQi5WLjELMAkGA1UECxMCSVQxFTATBgNVBAMTDE9uZWdpbmkgQi5WLjEfMB0GCSqGSIb3DQEJARYQaW5mb0BvbmVnaW5pLmNvbTAeFw0xNTAzMDMwOTQ4MDVaFw0yMDAzMDEwOTQ4MDVaMIGNMQswCQYDVQQGEwJOTDEQMA4GA1UECBMHVXRyZWNodDEQMA4GA1UEBxMHV29lcmRlbjEVMBMGA1UEChMMT25lZ2luaSBCLlYuMQswCQYDVQQLEwJJVDEVMBMGA1UEAxMMT25lZ2luaSBCLlYuMR8wHQYJKoZIhvcNAQkBFhBpbmZvQG9uZWdpbmkuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuLmNPSanYb0wJl/f+yUtjslSUVpwfdZnL0ssZ/JQ1GZMD16zqfWWd2g3uIU73B8I4hlHTW84gqXwCE+/SrPJ5S/5DB3B4Bn8Gu9kBjIbJlwv2TqGnNV19Qe6dZxP3qYaWJy/W7PZ/IxbM8DeRrhQENwnpoYWEvwXH9kDtE/EeIJvwpNBj2WXztWaIpDdd/6DxQ1736OZ8zJuTnmDcZ65EuksmBhDNddDzWjc3FItViQvMxylM0zBZouLFPQ+aaNByw0v5rFIcDhp8+GW9cOjKSs4/3vW8Y9cPbfAzvtbfFakLJwFkwrr8dfqRfjN/K6RsrjUwZ31A3LdDcYQlXRMOwIDAQABMA0GCSqGSIb3DQEBBQUAA4IBAQB7T8gcMymD4S5XD4qfn9KiG0ms6jLPjsFz9hTMy7+og+rlQsHSDSXZIS10hsXVw+PiGrv0XBWxT/w69jAtPnKVdduIsDq0PCz57b3VW/TliEvnQ5hzDnt0DF9RD/e42OQux6m5xqrQd0ZjppExTa7yN6SXPUltoHyZUzagraBPPAypSQWiCC7ZGwe/ioOtFKJgOf81Tb+mVbPQtcxodx6S4GENrxy1T2M5UBHBZyx5zPu/uIeP7EI5oxN8bSmU45iXvInBrtU+tsjtgyqAhy5H7cjBlar//8VvQYh//7ez5bP3ERwakwv03pFI3HkQavtRoCTIUEH9rDQR2RmS7l8F",

        /*
         *  Instead of use the whole x509cert you can use a fingerprint in order to
         *  validate a SAMLResponse.
         *  (openssl x509 -noout -fingerprint -in "idp.crt" to generate it,
         *   or add for example the -sha256 , -sha384 or -sha512 parameter)
         *
         *  If a fingerprint is provided, then the certFingerprintAlgorithm is required in order to
         *  let the toolkit know which algorithm was used. Possible values: sha1, sha256, sha384 or sha512
         *  'sha1' is the default value.
         *
         *  Notice that if you want to validate any SAML Message sent by the HTTP-Redirect binding, you
         *  will need to provide the whole x509cert.
         */
        // 'certFingerprint' => '',
        // 'certFingerprintAlgorithm' => 'sha1',

        /* In some scenarios the IdP uses different certificates for
         * signing/encryption, or is under key rollover phase and
         * more than one certificate is published on IdP metadata.
         * In order to handle that the toolkit offers that parameter.
         * (when used, 'x509cert' and 'certFingerprint' values are
         * ignored).
         */
        // 'x509certMulti' => array(
        //      'signing' => array(
        //          0 => '<cert1-string>',
        //      ),
        //      'encryption' => array(
        //          0 => '<cert2-string>',
        //      )
        // ),
    ),

    'security' => array(
        'requestedAuthnContext' => array('urn:com:onegini:saml:InlineLogin'),

        'inlineLoginKey' => 'cf0138d58946c6849a5d972c50830f76'
    )
);
