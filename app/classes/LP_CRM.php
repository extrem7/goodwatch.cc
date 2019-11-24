<?php

class LP_CRM {

	private $api = 'http://cashflow.lp-crm.top/api';

	private $key = 'c69658be166a8715e57b438e41e595d9';

	public function __construct() {
		$this->utms();
		add_action( 'woocommerce_thankyou', [ $this, 'sendOrder' ] );
	}

	private function utms() {
		$_SESSION['utms']                 = $_SESSION['utms'] ?? [];
		$_SESSION['utms']['utm_source']   = $_GET['utm_source'] ?? $_SESSION['utms']['utm_source'];
		$_SESSION['utms']['utm_medium']   = $_GET['utm_medium'] ?? $_SESSION['utms']['utm_medium'];
		$_SESSION['utms']['utm_term']     = $_GET['utm_term'] ?? $_SESSION['utms']['utm_term'];
		$_SESSION['utms']['utm_content']  = $_GET['utm_content'] ?? $_SESSION['utms']['utm_content'];
		$_SESSION['utms']['utm_campaign'] = $_GET['utm_campaign'] ?? $_SESSION['utms']['utm_campaign'];
	}

	public function sendOrder( int $orderId ) {
		$order    = wc_get_order( $orderId );
		$data     = $order->get_data();
		$billing  = $data['billing'];
		$shipping = $data['shipping'];

		$total = "Итого: " . $data['total'] . " грн";

		$delivery = '';
		$payment  = '';

		switch ( $_SESSION['shipping'] ) {
			case'Новая почта':
			case 'Нова пошта':
				$delivery = '1';
				break;
			case'Самовывоз':
			case 'Самовивіз':
				$delivery = '2';
				break;
			case'Укрпочта':
			case 'Укрпошта':
				$delivery = '3';
				break;
		}

		switch ( $_SESSION['payment'] ) {
			case'Приват 24':
				$payment = '2';
				break;
			case'Оплата при доставке':
			case 'Оплата при доставці':
				$payment = '4';
				break;
		}

		$products_list = [
			1 => [
				'product_id' => 291,
				'price'      => $data['total'],
				'count'      => '1'
			]
		];
		$productsCrm   = urlencode( serialize( $products_list ) );

		$products = [];
		foreach ( $order->get_items() as $item ) {
			$product    = $order->get_product_from_item( $item );
			$products[] = [
				//'Название'       => $product->get_name(),
				'ID товара'      => $product->get_id(),
				//'Артикул'        => $product->get_sku(),
				'Заказали (шт.)' => $item['qty'],
				'Ссылка'         => get_permalink( $product->get_id() )
			];
		}

		$startString = array_reduce( $products, function ( $r, $i ) {
				$id    = $i['ID товара'];
				$count = $i['Заказали (шт.)'];

				return $r . "$id - $count шт. ";
			}, '' ) . "\n$total\n";


		$productsString = "Товары:\n";
		foreach ( $products as $fields ) {
			foreach ( $fields as $key => $value ) {
				$productsString .= "$key: $value, ";
			}
			$productsString .= "\n";
		}

		$phone = $billing['phone'];
		/*$first  = substr( $phone, 2, 3 );
		$second = substr( $phone, 5, 3 );
		$third  = substr( $phone, 8, 2 );
		$fourth = substr( $phone, 10, 2 );*/
		$phone = substr( $phone, 2 );

		$comment = $startString . $productsString . "\n" . $data['customer_note'] . "\n$total";

		$data = [
			'key'      => $this->key,
			'order_id' => number_format( round( microtime( true ) * 10 ), 0, '.', '' ),
			'country'  => 'UA',
			'office'   => '',
			'products' => $productsCrm,

			'bayer_name' => $billing['first_name'] . ' ' . $billing['last_name'],
			'phone'      => $phone,
			'email'      => $billing['email'],
			'comment'    => $comment,

			'site' => $_SERVER['SERVER_NAME'],
			'ip'   => $_SERVER['REMOTE_ADDR'],

			'delivery'        => $delivery,
			'delivery_adress' => $shipping['address_1'],
			'payment'         => $payment,

			'utm_source'   => $_SESSION['utms']['utm_source'],
			'utm_medium'   => $_SESSION['utms']['utm_medium'],
			'utm_term'     => $_SESSION['utms']['utm_term'],
			'utm_content'  => $_SESSION['utms']['utm_content'],
			'utm_campaign' => $_SESSION['utms']['utm_campaign']
		];

		$this->curl( '/addNewOrder', $data );
	}

	private function curl( $point, $data ) {
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $this->api . $point . '.html' );
		curl_setopt( $curl, CURLOPT_POST, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
		$out = curl_exec( $curl );
		curl_close( $curl );
	}
}