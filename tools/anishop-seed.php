<?php
/**
 * Anishop one-time product seeder (run via CLI).
 *
 * Usage: php tools/anishop-seed.php
 *
 * Converts the Redmi Note 13 product into a variable product with
 * color/storage attributes, variations, rich content, spec table,
 * pre-defined Q&A and demo reviews.
 */

if ( PHP_SAPI !== 'cli' ) {
	exit( "CLI only\n" );
}

require __DIR__ . '/../wp-load.php';

if ( ! class_exists( 'WooCommerce' ) ) {
	exit( "WooCommerce is not active.\n" );
}

/* ---------------------------------------------------------------
 * Helpers
 * --------------------------------------------------------------- */
function anis_log( $msg ) {
	echo $msg . "\n";
}

function anis_ensure_global_attribute( $label, $slug, $type ) {
	$existing = wc_attribute_taxonomy_id_by_name( $slug );
	if ( $existing ) {
		return $existing;
	}

	$new_id = wc_create_attribute( array(
		'name'      => $label,
		'slug'      => $slug,
		'type'      => $type,
		'order_by'  => 'menu_order',
		'has_archives' => false,
	) );

	if ( is_wp_error( $new_id ) ) {
		anis_log( 'WARN attribute create failed: ' . $new_id->get_error_message() );
		return 0;
	}

	delete_transient( 'wc_attribute_taxonomies' );
	WC_Cache_Helper::invalidate_cache_group( 'woocommerce-attributes' );
	return (int) $new_id;
}

function anis_ensure_term( $taxonomy, $name, $slug, $meta = array() ) {
	$term = get_term_by( 'slug', $slug, $taxonomy );
	if ( ! $term ) {
		$res = wp_insert_term( $name, $taxonomy, array( 'slug' => $slug ) );
		if ( is_wp_error( $res ) ) {
			anis_log( 'WARN term insert failed (' . $slug . '): ' . $res->get_error_message() );
			$term = get_term_by( 'name', $name, $taxonomy );
		} else {
			$term = get_term( $res['term_id'], $taxonomy );
		}
	}
	if ( $term && ! is_wp_error( $term ) && $meta ) {
		foreach ( $meta as $k => $v ) {
			update_term_meta( $term->term_id, $k, $v );
		}
	}
	return $term;
}

/* ---------------------------------------------------------------
 * 1) Find the product
 * --------------------------------------------------------------- */
$redmi = get_page_by_path( 'goushi-shiaiaomi-redmi-note-13', OBJECT, 'product' );
if ( ! $redmi ) {
	$posts = get_posts( array(
		'post_type'   => 'product',
		'title'       => 'گوشی موبایل شیائومی مدل Redmi Note 13',
		'numberposts' => 1,
		'post_status' => 'any',
	) );
	$redmi = $posts ? $posts[0] : null;
}

if ( ! $redmi ) {
	anis_log( 'Product not found — creating a new one.' );
	$pid = wp_insert_post( array(
		'post_title'  => 'گوشی موبایل شیائومی مدل Redmi Note 13',
		'post_status' => 'publish',
		'post_type'   => 'product',
	) );
	$redmi = get_post( $pid );
} else {
	anis_log( 'Product found: ID=' . $redmi->ID . ' — updating.' );
	$pid = $redmi->ID;
}

/* ---------------------------------------------------------------
 * 2) Global attributes (color + storage)
 * --------------------------------------------------------------- */
anis_log( '— Global attributes —' );
anis_ensure_global_attribute( 'رنگ', 'color', 'select' );
anis_ensure_global_attribute( 'حافظه', 'storage', 'select' );

$color_terms = array(
	array( 'مشکی', 'meshki', array( 'color_hex' => '#1f2430' ) ),
	array( 'آبی', 'abi', array( 'color_hex' => '#3b82f6' ) ),
	array( 'سبز', 'sabz', array( 'color_hex' => '#16a34a' ) ),
	array( 'بنفش', 'banafsh', array( 'color_hex' => '#8b5cf6' ) ),
);
foreach ( $color_terms as $t ) {
	anis_ensure_term( 'pa_color', $t[0], $t[1], $t[2] );
}

$storage_terms = array(
	'128 گیگابایت / 6 گیگابایت رم' => '128gb-6gb',
	'256 گیگابایت / 8 گیگابایت رم' => '256gb-8gb',
	'128 گیگابایت / 4 گیگابایت رم' => '128gb-4gb',
);
foreach ( $storage_terms as $name => $slug ) {
	anis_ensure_term( 'pa_storage', $name, $slug );
}

/* ---------------------------------------------------------------
 * 3) Rich content
 * --------------------------------------------------------------- */
anis_log( '— Content —' );
$content = <<<HTML
<p>گوشی موبایل شیائومی Redmi Note 13 با ظرفیت ۲۵۶ گیگابایت و رم ۸ گیگابایت، تجربه‌ای بی‌نظیر از سرعت و کارایی را به شما هدیه می‌دهد. این دستگاه با طراحی مدرن و باتری قدرتمند، همراهی ایده‌آل برای تمام لحظات شماست.</p>
<p>در بین گوشی‌های شیائومی، سری ردمی نوت که گوشی‌های میان‌رده محسوب می‌شوند، از محبوبیت و فروش بسیار خوبی برخوردار هستند که البته با توجه به قیمت مناسب، امکانات و قابلیت‌های خوبی هم دارند. گوشی Redmi Note 13 در مقایسه با نسل گذشته، یعنی Redmi Note 12، استحکام بهتری دارد و در بخش‌های نمایشگر و دوربین بهبود چشمگیری داشته است.</p>
<h3>نقاط قوت گوشی شیائومی Redmi Note 13</h3>
<ul>
<li>نمایشگر AMOLED ۶٫۶۷ اینچی با نرخ نوسازی ۱۲۰ هرتز و روشنایی حداکثری ۱۸۰۰ نیت</li>
<li>دوربین اصلی ۱۰۸ مگاپیکسلی با جزئیات بالا و سلفی ۱۶ مگاپیکسلی</li>
<li>پردازنده اسنپدراگون ۶۸۵ و باتری ۵۰۰۰ میلی‌آمپر ساعتی با شارژ سریع ۳۳ وات</li>
<li>طراحی خوش‌دست با بدنه استاندارد IP54 و اسپیکرهای استریو</li>
</ul>
<h3>طراحی و نمایشگر</h3>
<p>ردمی نوت ۱۳ از زبان طراحی جدید شیائومی در سری ردمی نوت بهره گرفته است. فریم تخت، لبه‌های خمیده و ارگونومی خوب، حس یک گوشی پرچم‌دار را در ذهن تداعی می‌کند. این دستگاه با استاندارد محافظت IP54، وزن ۱۸۸٫۵ گرم و ضخامت ۸ میلی‌متر، ابعاد ایده‌آلی دارد و در چهار رنگ مشکی، سبز، آبی و بنفش عرضه شده است.</p>
<p>نمایشگر ۶٫۶۷ اینچی از پنل AMOLED با وضوح ۲۴۰۰×۱۰۸۰ پیکسل، شدت روشنایی حداکثر ۱۸۰۰ نیت و نرخ نوسازی ۱۲۰ هرتز بهره می‌برد. حاشیه‌های کم، پوشش کورنینگ گوریلا گلس ۳ و حسگر اثر انگشت زیر نمایشگر از دیگر ویژگی‌های آن است.</p>
<h3>دوربین؛ ثبت لحظه‌ها با جزئیات بالا</h3>
<p>ردمی نوت ۱۳ از سه دوربین در پنل پشتی بهره می‌برد: دوربین اصلی ۱۰۸ مگاپیکسلی با OVC، دوربین اولتراواید ۸ مگاپیکسلی و دوربین ماکرو ۲ مگاپیکسلی. دوربین سلفی ۱۶ مگاپیکسلی هم در پانچ‌هول بالای نمایشگر جاسازی شده است؛ هر دو دوربین اصلی و سلفی از فیلم‌برداری 1080p@30fps پشتیبانی می‌کنند.</p>
<h3>سخت‌افزار و باتری</h3>
<p>در قلب این گوشی، تراشه ۶ نانومتری و هشت‌هسته‌ای Snapdragon 685 با پردازنده گرافیکی Adreno 610 و رابط کاربری MIUI 14 روی اندروید ۱۳ قرار دارد. باتری لیتیوم-پلیمری ۵۰۰۰ میلی‌آمپر ساعتی با شارژر سیمی ۳۳ واتی، در ۷۰ دقیقه به‌طور کامل شارژ می‌شود.</p>
<h3>محتویات جعبه</h3>
<ul>
<li>گوشی موبایل شیائومی Redmi Note 13</li>
<li>آداپتور ۳۳ واتی و کابل USB Type-C</li>
<li>قاب محافظ سیلیکونی و ابزار سیم‌کارت</li>
<li>دفترچه راهنما و گارانتی رسمی آنی‌شاپ</li>
</ul>
<h3>راهنمای خرید</h3>
<p>پیش از خرید حتماً رنگ و پیکربندی حافظه (رم/حافظه داخلی) موردنظر خود را از باکس خرید انتخاب کنید. قیمت گوشی شیائومی Redmi Note 13 در آنی‌شاپ به‌صورت لحظه‌ای به‌روزرسانی می‌شود و تمامی گوشی‌ها دارای ۱۸ ماه گارانتی معتبر و ۷ روز ضمانت بازگشت کالا هستند.</p>
HTML;

wp_update_post( array(
	'ID'           => $pid,
	'post_content' => $content,
	'post_excerpt' => 'گوشی موبایل شیائومی Redmi Note 13 با نمایشگر AMOLED ۱۲۰ هرتزی، دوربین ۱۰۸ مگاپیکسلی، باتری ۵۰۰۰ میلی‌آمپری و شارژ سریع ۳۳ وات؛ یکی از بهترین انتخاب‌های میان‌رده بازار با گارانتی رسمی آنی‌شاپ.',
) );
anis_log( 'content + excerpt set.' );

/* ---------------------------------------------------------------
 * 4) Specs table (meta, admin editable)
 * --------------------------------------------------------------- */
anis_log( '— Specs —' );
$specs = array(
	'شبکه' => array(
		'تکنولوژی' => 'GSM / HSPA / LTE',
	),
	'عرضه' => array(
		'زمان معرفی' => '۱۵ ژانویه ۲۰۲۴ برابر با ۲۵ دی ۱۴۰۲',
		'وضعیت' => 'موجود در بازار',
	),
	'بدنه' => array(
		'ابعاد' => 'طول ۱۶۲٫۳ × عرض ۷۵٫۶ × ضخامت ۸ میلی‌متر',
		'وزن' => '۱۸۸٫۵ گرم',
		'سیم‌کارت' => 'دو سیم‌کارت (نانو)',
		'ساختار' => 'گلس جلو، پنل پلاستیکی پشت، فریم پلاستیکی',
		'مقاومت' => 'استاندارد IP54 (گردوغبار و پاشش آب)',
	),
	'صفحه‌نمایش' => array(
		'نوع' => 'AMOLED، ۱۲۰ هرتز، ۱۸۰۰ نیت (peak)',
		'سایز' => '۶٫۶۷ اینچ (~۸۷٫۵٪ نسبت نمایشگر به بدنه)',
		'رزولوشن' => '۱۰۸۰ × ۲۴۰۰ پیکسل (~۳۹۵ ppi)',
		'محافظ' => 'کورنینگ گوریلا گلس ۳',
	),
	'پلتفرم' => array(
		'سیستم‌عامل' => 'اندروید ۱۳',
		'رابط‌کاربری' => 'MIUI 14',
		'تراشه' => 'Qualcomm Snapdragon 685 (۶ نانومتری)',
		'پردازنده مرکزی' => 'هشت‌هسته‌ای (۴×Cortex-A73 2.8GHz و ۴×Cortex-A53 1.9GHz)',
		'پردازنده گرافیکی' => 'Adreno 610',
	),
	'حافظه' => array(
		'درگاه حافظه' => 'microSDXC (مشترک با سیم‌کارت دوم)',
		'حافظه داخلی' => '۱۲۸ / ۲۵۶ گیگابایت',
		'حافظه رم' => '۴ / ۶ / ۸ گیگابایت',
		'نوع حافظه' => 'UFS 2.2',
	),
	'دوربین اصلی' => array(
		'دوربین اصلی' => '۱۰۸ مگاپیکسل، f/1.8، فوکوس خودکار با تشخیص فاز',
		'دوربین اولتراواید' => '۸ مگاپیکسل، f/2.2، زاویه دید ۱۲۰ درجه',
		'دوربین ماکرو' => '۲ مگاپیکسل، f/2.4',
		'ویژگی‌ها' => 'فلش LED، پانوراما، HDR',
		'فیلم‌برداری' => '۱۰۸۰p@30fps',
	),
	'دوربین سلفی' => array(
		'دوربین سلفی' => '۱۶ مگاپیکسل، f/2.4 (عریض)',
		'فیلم‌برداری سلفی' => '۱۰۸۰p@30fps',
	),
	'صدا' => array(
		'اسپیکر' => 'استریو',
		'جک ۳٫۵ میلی‌متری' => 'دارد',
	),
	'اتصالات' => array(
		'وای‌فای' => 'Wi-Fi 802.11 a/b/g/n/ac، دو بانده',
		'بلوتوث' => 'نسخه ۵٫۱، A2DP، LE',
		'مکان‌یاب' => 'GPS / GLONASS / GALILEO / BDS',
		'NFC' => 'دارد',
		'مادون قرمز' => 'دارد',
		'درگاه اتصال' => 'USB Type-C 2.0، OTG',
	),
	'قابلیت‌ها' => array(
		'حسگرها' => 'اثر انگشت زیر نمایشگر، شتاب‌سنج، ژیروسکوپ، مجاورت، قطب‌نما',
	),
	'باتری' => array(
		'نوع' => 'لیتیوم-پلیمری ۵۰۰۰ میلی‌آمپر ساعت، غیرقابل تعویض',
		'شارژ' => 'سیمی ۳۳ وات (۵۰٪ در ۲۹ دقیقه، ۱۰۰٪ در ۷۰ دقیقه)',
	),
);
update_post_meta( $pid, '_anishop_specs', $specs );
anis_log( 'spec rows: ' . count( $specs ) . ' groups.' );

/* ---------------------------------------------------------------
 * 5) Pre-defined Q&A (admin editable via meta box)
 * --------------------------------------------------------------- */
anis_log( '— Q&A —' );
$qa = array(
	array(
		'q' => 'آیا گوشی شیائومی Redmi Note 13 رجیستر شده است؟',
		'a' => 'بله، تمامی گوشی‌های عرضه‌شده در آنی‌شاپ دارای رجیستر رسمی و گارانتی ۱۸ ماهه معتبر هستند.',
	),
	array(
		'q' => 'تفاوت نسخه ۴ گیگ رم با ۶ گیگ رم چیست؟',
		'a' => 'در اجرای همزمان چند اپلیکیشن و بازی‌های سنگین، نسخه ۶ گیگ رم روان‌تر عمل می‌کند؛ برای استفاده معمول هر دو نسخه مناسب هستند.',
	),
	array(
		'q' => 'آیا شارژر داخل جعبه موجود است؟',
		'a' => 'بله، آداپتور ۳۳ واتی، کابل Type-C و قاب محافظ داخل جعبه قرار دارد.',
	),
	array(
		'q' => 'آیا از کارت حافظه جانبی پشتیبانی می‌شود؟',
		'a' => 'بله، از microSD تا ۱ ترابایت پشتیبانی می‌شود؛ درگاه کارت حافظه با سیم‌کارت دوم مشترک است.',
	),
	array(
		'q' => 'گوشی اورجینال است؟ چطور اصالت آن را بررسی کنم؟',
		'a' => 'کالا کاملاً اورجینال است. پس از تحویل می‌توانید با کد IME از طریق سایت سامانه رجیستری اصالت کالا را استعلام بگیرید.',
	),
);
update_post_meta( $pid, '_anishop_qa', $qa );
anis_log( 'Q&A items: ' . count( $qa ) . '.' );

/* ---------------------------------------------------------------
 * 6) Convert to variable product + variations
 * --------------------------------------------------------------- */
anis_log( '— Variable product + variations —' );
$product = wc_get_product( $pid );

$color_tax  = 'pa_color';
$storage_tax = 'pa_storage';

$attrs_meta = $product->get_attributes();
$color_tid  = get_term_by( 'slug', 'meshki', $color_tax );
$colors_order = array( 'meshki', 'abi', 'sabz', 'banafsh' );
$color_term_ids = array();
foreach ( $colors_order as $slug ) {
	$t = get_term_by( 'slug', $slug, $color_tax );
	if ( $t && ! is_wp_error( $t ) ) {
		$color_term_ids[] = $t->term_id;
	}
}
$storage_term_ids = array();
foreach ( array( '128gb-6gb', '256gb-8gb', '128gb-4gb' ) as $slug ) {
	$t = get_term_by( 'slug', $slug, $storage_tax );
	if ( $t && ! is_wp_error( $t ) ) {
		$storage_term_ids[] = $t->term_id;
	}
}

$attr_color = new WC_Product_Attribute();
$attr_color->set_id( wc_attribute_taxonomy_id_by_name( 'color' ) );
$attr_color->set_name( $color_tax );
$attr_color->set_options( $color_term_ids );
$attr_color->set_position( 0 );
$attr_color->set_visible( true );
$attr_color->set_variation( true );

$attr_storage = new WC_Product_Attribute();
$attr_storage->set_id( wc_attribute_taxonomy_id_by_name( 'storage' ) );
$attr_storage->set_name( $storage_tax );
$attr_storage->set_options( $storage_term_ids );
$attr_storage->set_position( 1 );
$attr_storage->set_visible( true );
$attr_storage->set_variation( true );

$product->set_attributes( array( $attr_color, $attr_storage ) );
$product->save();

/* Variations: (storage_slug, color_slug, regular, sale, stock) */
$variations = array(
	array( '128gb-6gb', 'meshki', 8900000, 7950000, 7 ),
	array( '256gb-8gb', 'meshki', 10400000, 9350000, 12 ),
	array( '128gb-6gb', 'abi', 8900000, 7950000, 5 ),
	array( '256gb-8gb', 'abi', 10400000, 9280000, 9 ),
	array( '128gb-4gb', 'sabz', 7600000, 6990000, 3 ),
);

foreach ( $variations as $v ) {
	// Skip if already exists.
	$existing = get_posts( array(
		'post_type'   => 'product_variation',
		'post_parent' => $pid,
		'numberposts' => -1,
		'fields'      => 'ids',
	) );
	foreach ( $existing as $vid ) {
		$vs = get_post_meta( $vid, 'attribute_' . $storage_tax, true );
		$vc = get_post_meta( $vid, 'attribute_' . $color_tax, true );
		if ( $vs === $v[0] && $vc === $v[1] ) {
			continue 2;
		}
	}

	$variation = new WC_Product_Variation();
	$variation->set_parent_id( $pid );
	$variation->set_attributes( array(
		$storage_tax => $v[0],
		$color_tax   => $v[1],
	) );
	$variation->set_regular_price( $v[2] );
	$variation->set_sale_price( $v[3] );
	$variation->set_manage_stock( true );
	$variation->set_stock_quantity( $v[4] );
	$variation->set_stock_status( 'instock' );
	$variation->set_status( 'publish' );
	$variation->save();

	anis_log( '  variation: ' . $v[0] . ' × ' . $v[1] . ' → ID ' . $variation->get_id() );
}

wc_delete_product_transients( $pid );
anis_log( 'product type: ' . wc_get_product( $pid )->get_type() );

/* ---------------------------------------------------------------
 * 7) Demo reviews
 * --------------------------------------------------------------- */
anis_log( '— Reviews —' );
$already = get_comments( array(
	'post_id'    => $pid,
	'meta_key'   => 'anishop_seed',
	'meta_value' => 1,
	'status'     => 'any',
) );

if ( empty( $already ) ) {
	$reviews = array(
		array( 'نگین محمدی', 5, 'کیفیت ساخت و دوربینش فوق‌العاده‌ست؛ باتری هم راحت دو روز دووم میاره. ارسال آنی‌شاپ هم خیلی سریع بود.', 'خریدار', true ),
		array( 'محمد رضایی', 4, 'برای قیمتش عالیه. فقط کاش نسخه شارژر سریع‌تر داشت. بسته‌بندی سالم و گارانتی معتبر بود.', 'خریدار', true ),
		array( 'سارا کریمی', 5, 'نمایشگرش واقعا چشم‌نوازه، عکس‌های شب هم قابل قبول گرفتن. از خرید راضی‌ام.', 'خریدار', true ),
		array( 'علی طاهری', 4, 'پردازنده برای بازی‌های سبک کاملا کافیه، رم ۸ گیگ هم لذت کار با گوشی دوچندان کرده. پیشنهاد می‌کنم.', 'خریدار', false ),
	);
	foreach ( $reviews as $r ) {
		$cid = wp_insert_comment( array(
			'comment_post_ID'      => $pid,
			'comment_author'       => $r[0],
			'comment_author_email' => '',
			'comment_content'      => $r[2],
			'comment_approved'     => 1,
			'comment_type'         => 'review',
			'comment_date'         => gmdate( 'Y-m-d H:i:s', time() - rand( 3, 120 ) * DAY_IN_SECONDS ),
		) );
		if ( $cid ) {
			add_comment_meta( $cid, 'rating', (int) $r[1], true );
			add_comment_meta( $cid, 'verified', $r[3] ? 1 : 0, true );
			add_comment_meta( $cid, 'anishop_seed', 1, true );
			add_comment_meta( $cid, '_anishop_title', $r[4], true );
		}
	}
	anis_log( 'inserted ' . count( $reviews ) . ' reviews.' );
} else {
	anis_log( 'reviews already seeded, skipping.' );
}

/* ---------------------------------------------------------------
 * 8) Done
 * --------------------------------------------------------------- */
anis_log( '' );
anis_log( 'DONE. Product ID: ' . $pid );
anis_log( 'URL: ' . get_permalink( $pid ) );
