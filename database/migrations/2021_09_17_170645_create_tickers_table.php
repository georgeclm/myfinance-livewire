<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('code');
            $table->timestamps();
        });
        DB::unprepared("INSERT INTO tickers (nama, code) VALUES
        ('Astra Agro Lestari Tbk.','AALI'),
        ('Mahaka Media Tbk.','ABBA'),
        ('Asuransi Bina Dana Arta Tbk.','ABDA'),
        ('ABM Investama Tbk.	','ABMM'),
        ('Ace Hardware Indonesia Tbk.	','ACES'),
        ('Acset Indonusa Tbk.	','ACST'),
        ('Akasha Wira International Tbk.	','ADES'),
        ('Adhi Karya (Persero) Tbk.	','ADHI'),
        ('Adira Dinamika Multi Finance T	','ADMF'),
        ('Polychem Indonesia Tbk	','ADMG'),
        ('Adaro Energy Tbk.	','ADRO'),
        ('Asia Sejahtera Mina Tbk.	','AGAR'),
        ('Aneka Gas Industri Tbk.	','AGII'),
        ('Bank Rakyat Indonesia Agroniag	','AGRO'),
        ('Bank IBK Indonesia Tbk.	','AGRS'),
        ('Asuransi Harta Aman Pratama Tb	','AHAP'),
        ('Akbar Indo Makmur Stimec Tbk	','AIMS'),
        ('FKS Food Sejahtera Tbk.	','AISA'),
        ('Anugerah Kagum Karya Utama Tbk	','AKKU'),
        ('Argha Karya Prima Industry Tbk	','AKPI'),
        ('AKR Corporindo Tbk.	','AKRA'),
        ('Maming Enam Sembilan Mineral T	','AKSI'),
        ('Alkindo Naratama Tbk.	','ALDO'),
        ('Alakasa Industrindo Tbk	','ALKA'),
        ('Alumindo Light Metal Industry	','ALMI'),
        ('Tri Banyan Tirta Tbk.	','ALTO'),
        ('Asuransi Multi Artha Guna Tbk.	','AMAG'),
        ('Makmur Berkah Amanda Tbk.	','AMAN'),
        ('Bank Amar Indonesia Tbk.	','AMAR'),
        ('Asahimas Flat Glass Tbk.	','AMFG'),
        ('Ateliers Mecaniques D Indonesi	','AMIN'),
        ('Ashmore Asset Management Indon	','AMOR'),
        ('Sumber Alfaria Trijaya Tbk.	','AMRT'),
        ('Andira Agro Tbk.	','ANDI'),
        ('Austindo Nusantara Jaya Tbk.	','ANJT'),
        ('Aneka Tambang Tbk.	','ANTM'),
        ('Apexindo Pratama Duta Tbk.	','APEX'),
        ('Pacific Strategic Financial Tb	','APIC'),
        ('Arita Prima Indonesia Tbk.	','APII'),
        ('Asiaplast Industries Tbk.	','APLI'),
        ('Agung Podomoro Land Tbk.	','APLN'),
        ('Archi Indonesia Tbk.	','ARCI'),
        ('Argo Pantes Tbk	','ARGO'),
        ('Atlas Resources Tbk.	','ARII'),
        ('Arkha Jayanti Persada Tbk.	','ARKA'),
        ('Armidian Karyatama Tbk.	','ARMY'),
        ('Arwana Citramulia Tbk.	','ARNA'),
        ('Arthavest Tbk	','ARTA'),
        ('Ratu Prabu Energi Tbk	','ARTI'),
        ('Bank Jago Tbk.	','ARTO'),
        ('Asuransi Bintang Tbk.	','ASBI'),
        ('Asuransi Dayin Mitra Tbk.	','ASDM'),
        ('Astra Graphia Tbk.	','ASGR'),
        ('Astra International Tbk.	','ASII'),
        ('Asuransi Jasa Tania Tbk.	','ASJT'),
        ('Asuransi Maximus Graha Persada	','ASMI'),
        ('Andalan Sakti Primaindo Tbk.	','ASPI'),
        ('Alam Sutera Realty Tbk.	','ASRI'),
        ('Asuransi Ramayana Tbk.	','ASRM'),
        ('Adi Sarana Armada Tbk.	','ASSA'),
        ('Trimitra Prawara Goldland Tbk.	','ATAP'),
        ('Anabatic Technologies Tbk.	','ATIC'),
        ('Astra Otoparts Tbk.	','AUTO'),
        ('Agro Yasa Lestari Tbk.','AYLS'),
        ('Bank MNC Internasional Tbk.	','BABP'),
        ('Bank Capital Indonesia Tbk.	','BACA'),
        ('Saranacentral Bajatama Tbk.	','BAJA'),
        ('Bali Towerindo Sentra Tbk.	','BALI'),
        ('Bank Aladin Syariah Tbk.	','BANK'),
        ('Bekasi Asri Pemula Tbk.	','BAPA'),
        ('Bhakti Agung Propertindo Tbk.	','BAPI'),
        ('Sepatu Bata Tbk.	','BATA'),
        ('Bayu Buana Tbk	','BAYU'),
        ('Bank Central Asia Tbk.	','BBCA'),
        ('Allo Bank Indonesia Tbk.	','BBHI'),
        ('Bank KB Bukopin Tbk.	','BBKP'),
        ('Buana Finance Tbk.	','BBLD'),
        ('Bank Mestika Dharma Tbk.	','BBMD'),
        ('Bank Negara Indonesia (Persero	','BBNI'),
        ('Bank Rakyat Indonesia (Persero	','BBRI'),
        ('Pelayaran Nasional Bina Buana	','BBRM'),
        ('Bank Bisnis Internasional Tbk.	','BBSI'),
        ('Bumi Benowo Sukses Sejahtera T	','BBSS'),
        ('Bank Tabungan Negara (Persero)	','BBTN'),
        ('Bank Neo Commerce Tbk.	','BBYB'),
        ('MNC Kapital Indonesia Tbk.	','BCAP'),
        ('Bank JTrust Indonesia Tbk.	','BCIC'),
        ('Bumi Citra Permai Tbk.	','BCIP	'),
        ('Bank Danamon Indonesia Tbk.	.','BDMN'),
        ('Berkah Beton Sadaya Tbk.	','BEBS'),
        ('Estika Tata Tiara Tbk.','BEEF'),
        ('Bank Pembangunan Daerah Banten','BEKS'),
        ('Trisula Textile Industries Tbk','BELL'),
        ('Batulicin Nusantara Maritim Tb','BESS'),
        ('Bekasi Fajar Industrial Estate','BEST'),
        ('BFI Finance Indonesia Tbk.','BFIN'),
        ('Bank Ganesha Tbk.	','BGTG'),
        ('Bhakti Multi Artha Tbk.','BHAT'),
        ('MNC Investama Tbk.','BHIT'),
        ('Binakarya Jaya Abadi Tbk.	','BIKA'),
        ('Primarindo Asia Infrastructure	','BIMA'),
        ('Bank Ina Perdana Tbk.	','BINA'),
        ('Astrindo Nusantara Infrastrukt	','BIPI'),
        ('Bhuwanatala Indah Permai Tbk.	','BIPP'),
        ('Blue Bird Tbk.	','BIRD'),
        ('BISI International Tbk.	','BISI'),
        ('Bank Pembangunan Daerah Jawa B	','BJBR'),
        ('Bank Pembangunan Daerah Jawa T	','BJTM'),
        ('Bukit Darmo Property Tbk	','BKDP'),
        ('Sentul City Tbk.	','BKSL'),
        ('Bank QNB Indonesia Tbk.	','BKSW'),
        ('Berlian Laju Tanker Tbk	','BLTA'),
        ('Graha Layar Prima Tbk.	','BLTZ'),
        ('Berkah Prima Perkasa Tbk.	','BLUE'),
        ('Bank Maspion Indonesia Tbk.	','BMAS'),
        ('Bundamedik Tbk.	','BMHS'),
        ('Bank Mandiri (Persero) Tbk.	','BMRI'),
        ('Bintang Mitra Semestaraya Tbk	','BMSR'),
        ('Global Mediacom Tbk.	','BMTR'),
        ('Bank Bumi Arta Tbk.	','BNBA'),
        ('Bakrie & Brothers Tbk	','BNBR'),
        ('Bank CIMB Niaga Tbk.	','BNGA'),
        ('Bank Maybank Indonesia Tbk.	','BNII'),
        ('Bank Permata Tbk.	','BNLI'),
        ('Bintang Oto Global Tbk.	','BOGA'),
        ('Bali Bintang Sejahtera Tbk.	','BOLA'),
        ('Garuda Metalindo Tbk.	','BOLT'),
        ('Borneo Olah Sarana Sukses Tbk.	','BOSS'),
        ('Batavia Prosperindo Finance Tb	','BPFI'),
        ('Batavia Prosperindo Internasio	','BPII'),
        ('Batavia Prosperindo Trans Tbk.	','BPTR'),
        ('Indo Kordsa Tbk.	','BRAM'),
        ('Bank Syariah Indonesia Tbk.	','BRIS'),
        ('Bumi Resources Minerals Tbk.	','BRMS'),
        ('Berlina Tbk.	','BRNA'),
        ('Barito Pacific Tbk.	','BRPT'),
        ('Bumi Serpong Damai Tbk.	','BSDE'),
        ('Bank Sinarmas Tbk.	','BSIM'),
        ('Baramulti Suksessarana Tbk.	','BSSR'),
        ('Bank Of India Indonesia Tbk.	','BSWD'),
        ('Bumi Teknokultura Unggul Tbk	','BTEK'),
        ('Bakrie Telecom Tbk.	','BTEL'),
        ('Betonjaya Manunggal Tbk.	','BTON'),
        ('Bank BTPN Tbk.	','BTPN'),
        ('Bank BTPN Syariah Tbk.	','BTPS'),
        ('Budi Starch & Sweetener Tbk.	','BUDI'),
        ('Bukalapak.com Tbk.	','BUKA'),
        ('Bukaka Teknik Utama Tbk.	','BUKK'),
        ('Buana Lintas Lautan Tbk.	','BULL'),
        ('Bumi Resources Tbk.	','BUMI'),
        ('Bukit Uluwatu Villa Tbk.	','BUVA'),
        ('Bank Victoria International Tb	','BVIC'),
        ('Eagle High Plantations Tbk.	','BWPT'),
        ('Bayan Resources Tbk.	','BYAN'),
        ('Cahayaputra Asa Keramik Tbk.	','CAKK'),
        ('Campina Ice Cream Industry Tbk	','CAMP'),
        ('Capitol Nusantara Indonesia Tb	','CANI'),
        ('Metro Healthcare Indonesia Tbk	','CARE'),
        ('Industri dan Perdagangan Bintr	','CARS'),
        ('Capital Financial Indonesia Tb	','CASA'),
        ('Cashlez Worldwide Indonesia Tb	','CASH'),
        ('Cardig Aero Services Tbk.	','CASS'),
        ('Cahaya Bintang Medan Tbk.	','CBMF'),
        ('Communication Cable Systems In	','CCSI'),
        ('Wilmar Cahaya Indonesia Tbk.	','CEKA'),
        ('Centratama Telekomunikasi Indo	','CENT'),
        ('Clipan Finance Indonesia Tbk.	','CFIN'),
        ('Chitose Internasional Tbk.	','CINT'),
        ('Cita Mineral Investindo Tbk.	','CITA'),
        ('Natura City Developments Tbk.	','CITY'),
        ('Citra Putra Realty Tbk.	','CLAY'),
        ('Sariguna Primatirta Tbk.	','CLEO'),
        ('Colorpak Indonesia Tbk.	','CLPI'),
        ('Citra Marga Nusaphala Persada	','CMNP'),
        ('Cemindo Gemilang Tbk.	','CMNT'),
        ('AirAsia Indonesia Tbk.	','CMPP'),
        ('Exploitasi Energi Indonesia Tb	','CNKO'),
        ('Century Textile Industry Tbk.	','CNTX'),
        ('Wahana Interfood Nusantara Tbk	','COCO'),
        ('Cowell Development Tbk.	','COWL'),
        ('Charoen Pokphand Indonesia Tbk	','CPIN'),
        ('Capri Nusa Satu Properti Tbk.	','CPRI'),
        ('Central Proteina Prima Tbk.	','CPRO'),
        ('Catur Sentosa Adiprana Tbk.	','CSAP'),
        ('Cahayasakti Investindo Sukses	','CSIS'),
        ('Cipta Selera Murni Tbk.	','CSMI'),
        ('Cisadane Sawit Raya Tbk.	','CSRA'),
        ('Citra Tubindo Tbk.	','CTBN'),
        ('Ciputra Development Tbk.	','CTRA'),
        ('Citatah Tbk.	','CTTH'),
        ('Diamond Citra Propertindo Tbk.	','DADA'),
        ('Duta Anggada Realty Tbk.	','DART'),
        ('Duta Intidaya Tbk.	','DAYA'),
        ('DCI Indonesia Tbk.	','DCII'),
        ('Dewata Freightinternational Tb	','DEAL'),
        ('Danasupra Erapacific Tbk.	','DEFI'),
        ('Darma Henwa Tbk	','DEWA'),
        ('Dafam Property Indonesia Tbk.	','DFAM'),
        ('Nusa Konstruksi Enjiniring Tbk	','DGIK'),
        ('Diagnos Laboratorium Utama Tbk	','DGNS'),
        ('Arkadia Digital Media Tbk.	','DIGI'),
        ('Intiland Development Tbk.	','DILD'),
        ('Distribusi Voucher Nusantara T	','DIVA'),
        ('Central Omega Resources Tbk.	','DKFT'),
        ('Delta Djakarta Tbk.	','DLTA'),
        ('Puradelta Lestari Tbk.	','DMAS'),
        ('Digital Mediatama Maxima Tbk.	','DMMX'),
        ('Diamond Food Indonesia Tbk.	','DMND'),
        ('Bank Oke Indonesia Tbk.	','DNAR'),
        ('Indoritel Makmur Internasional	','DNET'),
        ('Delta Dunia Makmur Tbk.	','DOID'),
        ('Duta Pertiwi Nusantara Tbk.	','DPNS'),
        ('Dua Putra Utama Makmur Tbk.	','DPUM'),
        ('Dharma Samudera Fishing Indust	','DSFI'),
        ('Dharma Satya Nusantara Tbk.	','DSNG'),
        ('Dian Swastatika Sentosa Tbk	','DSSA'),
        ('Jaya Bersama Indo Tbk.	','DUCK'),
        ('Duta Pertiwi Tbk	','DUTI'),
        ('Darya-Varia Laboratoria Tbk.	','DVLA'),
        ('Dwi Guna Laksana Tbk.	','DWGL'),
        ('Dyandra Media International Tb	','DYAN'),
        ('Eastparc Hotel Tbk.	','EAST'),
        ('Electronic City Indonesia Tbk.	','ECII'),
        ('Indointernet Tbk.	','EDGE'),
        ('Ekadharma International Tbk.	','EKAD'),
        ('Elnusa Tbk.	','ELSA'),
        ('Bakrieland Development Tbk.	','ELTY'),
        ('Megapolitan Developments Tbk.	','EMDE'),
        ('Elang Mahkota Teknologi Tbk.	','EMTK'),
        ('Energi Mega Persada Tbk.	','ENRG'),
        ('Envy Technologies Indonesia Tb	','ENVY'),
        ('Morenzo Abadi Perkasa Tbk.	','ENZO'),
        ('Megalestari Epack Sentosaraya	','EPAC'),
        ('Enseval Putera Megatrading Tbk	','EPMT'),
        ('Erajaya Swasembada Tbk.	','ERAA'),
        ('Eratex Djaja Tbk.	','ERTX'),
        ('Sinergi Inti Plastindo Tbk.	','ESIP'),
        ('Surya Esa Perkasa Tbk.	','ESSA'),
        ('Esta Multi Usaha Tbk.	','ESTA'),
        ('Ever Shine Tex Tbk.	','ESTI'),
        ('Eterindo Wahanatama Tbk	','ETWA'),
        ('XL Axiata Tbk.	','EXCL'),
        ('FAP Agri Tbk.	','FAPA'),
        ('Fast Food Indonesia Tbk.	','FAST'),
        ('Fajar Surya Wisesa Tbk.	','FASW'),
        ('MD Pictures Tbk.	','FILM'),
        ('Fimperkasa Utama Tbk.	','FIMP'),
        ('Alfa Energi Investama Tbk.	','FIRE'),
        ('FKS Multi Agro Tbk.	','FISH'),
        ('Hotel Fitra International Tbk.	','FITT'),
        ('Falmaco Nonwoven Industri Tbk.	','FLMC'),
        ('Fortune Mate Indonesia Tbk	','FMII'),
        ('Sentra Food Indonesia Tbk.	','FOOD'),
        ('Fortune Indonesia Tbk	','FORU'),
        ('Forza Land Indonesia Tbk.	','FORZ'),
        ('Lotte Chemical Titan Tbk.	','FPNI'),
        ('Smartfren Telecom Tbk.	','FREN'),
        ('Fuji Finance Indonesia Tbk.	','FUJI'),
        ('Hotel Fitra International Tbk.	','GAMA'),
        ('Aksara Global Development Tbk.	','GDST'),
        ('Goodyear Indonesia Tbk.	','GDYR'),
        ('Gema Grahasarana Tbk.	','GEMA'),
        ('Golden Energy Mines Tbk.	','GEMS'),
        ('Gudang Garam Tbk.	','GGRM'),
        ('Gunung Raja Paksi Tbk.	','GGRP'),
        ('Gihon Telekomunikasi Indonesia	','GHON'),
        ('Garuda Indonesia (Persero) Tbk	','GIAA'),
        ('Gajah Tunggal Tbk.	','GJTL'),
        ('Globe Kita Terang Tbk.	','GLOB'),
        ('Galva Technologies Tbk.	','GLVA'),
        ('Garuda Maintenance Facility Ae	','GMFI'),
        ('Gowa Makassar Tourism Developm	','GMTD'),
        ('Visi Telekomunikasi Infrastruk	','GOLD'),
        ('Golden Plantation Tbk.	','GOLL'),
        ('Garudafood Putra Putri Jaya Tb	','GOOD'),
        ('Perdana Gapuraprima Tbk.	','GPRA'),
        ('Geoprima Solusi Tbk.	','GPSO'),
        ('Equity Development Investment	','GSMF'),
        ('Garda Tujuh Buana Tbk	','GTBO'),
        ('GTS Internasional Tbk.	','GTSI'),
        ('Greenwood Sejahtera Tbk.	','GWSA'),
        ('Gozco Plantations Tbk.	','GZCO'),
        ('Himalaya Energi Perkasa Tbk.	','HADE'),
        ('Hasnur Internasional Shipping	','HAIS'),
        ('Radana Bhaskara Finance Tbk.	','HDFA'),
        ('Hensel Davest Indonesia Tbk.	','HDIT'),
        ('Panasia Indo Resources Tbk.	','HDTX'),
        ('Medikaloka Hermina Tbk.	','HEAL'),
        ('Jaya Trishindo Tbk.	','HELI'),
        ('Hero Supermarket Tbk.	','HERO'),
        ('Hexindo Adiperkasa Tbk.	','HEXA'),
        ('Humpuss Intermoda Transportasi	','HITS'),
        ('HK Metals Utama Tbk.	','HKMU'),
        ('H.M. Sampoerna Tbk.	','HMSP'),
        ('Buyung Poetra Sembada Tbk.	','HOKI'),
        ('Hotel Mandarine Regency Tbk.	','HOME'),
        ('Grand House Mulia Tbk.	','HOMI'),
        ('Harapan Duta Pertiwi Tbk.	','HOPE'),
        ('Saraswati Griya Lestari Tbk.	','HOTL'),
        ('Menteng Heritage Realty Tbk.	','HRME'),
        ('Hartadinata Abadi Tbk.	','HRTA'),
        ('Harum Energy Tbk.	','HRUM'),
        ('Indonesia Transport & Infrastr	','IATA'),
        ('Intan Baruprana Finance Tbk.	','IBFN'),
        ('Inti Bangun Sejahtera Tbk.	','IBST'),
        ('Indofood CBP Sukses Makmur Tbk	','ICBP'),
        ('Island Concepts Indonesia Tbk.	','ICON'),
        ('Idea Indonesia Akademi Tbk.	','IDEA'),
        ('Indonesia Pondasi Raya Tbk.	','IDPR'),
        ('Indonesia Fibreboard Industry	','IFII'),
        ('Ifishdeco Tbk.	','IFSH'),
        ('Champion Pacific Indonesia Tbk	','IGAR'),
        ('Inti Agri Resources Tbk	','IIKP'),
        ('Intikeramik Alamasri Industri	','IKAI'),
        ('Era Mandiri Cemerlang Tbk.	','IKAN'),
        ('Sumi Indo Kabel Tbk.	','IKBI'),
        ('Indomobil Sukses Internasional	','IMAS'),
        ('Indomobil Multi Jasa Tbk.	','IMJS'),
        ('Impack Pratama Industri Tbk.	','IMPC'),
        ('Indofarma Tbk.	','INAF'),
        ('Indal Aluminium Industry Tbk.	','INAI'),
        ('Indo Komoditi Korpora Tbk.	','INCF'),
        ('Intanwijaya Internasional Tbk	','INCI'),
        ('Vale Indonesia Tbk.	','INCO'),
        ('Indofood Sukses Makmur Tbk.	','INDF'),
        ('Royalindo Investa Wijaya Tbk.	','INDO'),
        ('Indo-Rama Synthetics Tbk.	','INDR'),
        ('Indospring Tbk.	','INDS'),
        ('Tanah Laut Tbk	','INDX'),
        ('Indika Energy Tbk.	','INDY'),
        ('Indah Kiat Pulp & Paper Tbk.	','INKP'),
        ('Inocycle Technology Group Tbk.	','INOV'),
        ('Bank Artha Graha Internasional	','INPC'),
        ('Indonesian Paradise Property T	','INPP'),
        ('Indah Prakasa Sentosa Tbk.	','INPS'),
        ('Toba Pulp Lestari Tbk.	','INRU'),
        ('Intraco Penta Tbk.	','INTA'),
        ('Inter Delta Tbk	','INTD'),
        ('Indocement Tunggal Prakarsa Tb	','INTP'),
        ('Era Graharealty Tbk.	','IPAC'),
        ('Indonesia Kendaraan Terminal T	','IPCC'),
        ('Jasa Armada Indonesia Tbk.	','IPCM'),
        ('MNC Vision Networks Tbk.	','IPOL'),
        ('Indonesian Paradise Property T	','IPTV'),
        ('Itama Ranoraya Tbk.	','IRRA'),
        ('Indosat Tbk.	','ISAT'),
        ('Steel Pipe Industry of Indones	','ISSP'),
        ('Indonesian Tobacco Tbk.	','ITIC'),
        ('Sumber Energi Andalan Tbk.	','ITMA'),
        ('Indo Tambangraya Megah Tbk.	','ITMG'),
        ('Jasnita Telekomindo Tbk.	','JAST'),
        ('Jaya Agra Wattie Tbk.	','JAWA'),
        ('Armada Berjaya Trans Tbk.	','JAYA'),
        ('Jembo Cable Company Tbk.	','JECC'),
        ('Graha Andrasentra Propertindo	','JGLE'),
        ('Jakarta International Hotels &	','JIHD'),
        ('Jaya Konstruksi Manggala Prata	','JKON'),
        ('Jakarta Kyoei Steel Works Tbk.	','JKSW'),
        ('Asuransi Jiwa Syariah Jasa Mit	','JMAS'),
        ('Japfa Comfeed Indonesia Tbk.	','JPFA'),
        ('Jaya Real Property Tbk.	','JRPT'),
        ('Sky Energy Indonesia Tbk.	','JSKY'),
        ('Jasa Marga (Persero) Tbk.	','JSMR'),
        ('Jakarta Setiabudi Internasiona	','JSPT'),
        ('Jasuindo Tiga Perkasa Tbk.	','JTPE'),
        ('Kimia Farma Tbk.	','KAEF'),
        ('ICTSI Jasa Prima Tbk.	','KARW'),
        ('Darmi Bersaudara Tbk.	','KAYU	'),
        ('Karya Bersama Anugerah Tbk.	','KBAG'),
        ('KMI Wire & Cable Tbk.	','KBLI'),
        ('Kabelindo Murni Tbk.	','KBLM'),
        ('First Media Tbk.	','KBLV'),
        ('Kertas Basuki Rachmat Indonesi	','KBRI'),
        ('Kedawung Setia Industrial Tbk.	','KDSI'),
        ('Kencana Energi Lestari Tbk.	','KEEN'),
        ('Mulia Boga Raya Tbk.	','KEJU'),
        ('Keramika Indonesia Assosiasi T	','KIAS'),
        ('Kedaung Indah Can Tbk	','KICI	'),
        ('Kawasan Industri Jababeka Tbk.	','KIJA'),
        ('Kino Indonesia Tbk.	','KINO'),
        ('Kioson Komersial Indonesia Tbk	','KIOS'),
        ('Krida Jaringan Nusantara Tbk.	','KJEN'),
        ('Resource Alam Indonesia Tbk.	','KKGI'),
        ('Kalbe Farma Tbk.	','KLBF'),
        ('Kurniamitra Duta Sentosa Tbk.	','KMDS'),
        ('Kirana Megatara Tbk.	','KMTR'),
        ('Kobexindo Tractors Tbk.	','KOBX'),
        ('Kokoh Inti Arebama Tbk	','KOIN	'),
        ('Perdana Bangun Pusaka Tbk	','KONI'),
        ('Mitra Energi Persada Tbk.	','KOPI'),
        ('DMS Propertindo Tbk.	','KOTA'),
        ('Steadfast Marine Tbk.	','KPAL'),
        ('Cottonindo Ariesta Tbk.	','KPAS'),
        ('MNC Land Tbk.	','KPIG'),
        ('Grand Kartech Tbk.	','KRAH'),
        ('Krakatau Steel (Persero) Tbk.	','KRAS'),
        ('Kresna Graha Investama Tbk.	','KREN'),
        ('Ladangbaja Murni Tbk.	','LABA	'),
        ('Trimitra Propertindo Tbk.	','LAND'),
        ('Leyand International Tbk.	','LAPD'),
        ('Eureka Prima Jakarta Tbk.	','LCGP'),
        ('LCK Global Kedaton Tbk.	','LCKM'),
        ('Logindo Samudramakmur Tbk.	','LEAD'),
        ('Imago Mulia Persada Tbk.	','LFLO'),
        ('Asuransi Jiwa Sinarmas MSIG Tb	','LIFE'),
        ('Link Net Tbk.	','LINK'),
        ('Lion Metal Works Tbk.	','LION'),
        ('Limas Indonesia Makmur Tbk	','LMAS	'),
        ('Langgeng Makmur Industri Tbk.	','LMPI'),
        ('Lionmesh Prima Tbk.	','LMSH'),
        ('Lippo Cikarang Tbk	','LPCK'),
        ('Lippo General Insurance Tbk.	','LPGI'),
        ('Multi Prima Sejahtera Tbk	','LPIN'),
        ('Lippo Karawaci Tbk.	','LPKR'),
        ('Star Pacific Tbk	','LPLI'),
        ('Matahari Department Store Tbk.	','LPPF'),
        ('Lenox Pasifik Investama Tbk.	','LPPS'),
        ('Eka Sari Lorena Transport Tbk.	','LRNA	'),
        ('PP London Sumatra Indonesia Tb	','LSIP'),
        ('Lautan Luas Tbk.	','LTLS'),
        ('Sentral Mitra Informatika Tbk.	','LUCK'),
        ('Lima Dua Lima Tiga Tbk.	','LUCY'),
        ('Marga Abhinaya Abadi Tbk.	','MABA'),
        ('Multi Agro Gemilang Plantation	','MAGP'),
        ('Malindo Feedmill Tbk.	','MAIN'),
        ('Mas Murni Indonesia Tbk	','MAMI'),
        ('Map Aktif Adiperkasa Tbk.	','MAPA'),
        ('MAP Boga Adiperkasa Tbk.	','MAPB	'),
        ('Mitra Adiperkasa Tbk.	','MAPI'),
        ('Mahaka Radio Integra Tbk.	','MARI'),
        ('Mark Dynamics Indonesia Tbk.	','MARK'),
        ('Multistrada Arah Sarana Tbk.	','MASA'),
        ('Bank Multiarta Sentosa Tbk.	','MASB'),
        ('Bank Mayapada Internasional Tb	','MAYA'),
        ('Mitrabara Adiperdana Tbk.	','MBAP'),
        ('Mitrabahtera Segara Sejati Tbk	','MBSS'),
        ('Martina Berto Tbk.	','MBTO'),
        ('M Cash Integrasi Tbk.	','MCAS	'),
        ('Prima Andalan Mandiri Tbk.	','MCOL'),
        ('Bank China Construction Bank I	','MCOR'),
        ('Intermedia Capital Tbk.	','MDIA	'),
        ('Merdeka Copper Gold Tbk.	','MDKA'),
        ('Emdeki Utama Tbk.	','MDKI'),
        ('Modernland Realty Tbk.	','MDLN'),
        ('Modern Internasional Tbk.	','MDRN'),
        ('Medco Energi Internasional Tbk	','MEDC'),
        ('Bank Mega Tbk.	','MEGA'),
        ('Merck Tbk.	','MERK	'),
        ('Nusantara Infrastructure Tbk.	','META'),
        ('Mandala Multifinance Tbk.	','MFIN'),
        ('Multifiling Mitra Indonesia Tb	','MFMI	'),
        ('Panca Anugrah Wisesa Tbk.	','MGLV'),
        ('Magna Investama Mandiri Tbk.	','MGNA'),
        ('Mahkota Group Tbk.	','MGRO'),
        ('Multi Indocitra Tbk.	','MICE'),
        ('Midi Utama Indonesia Tbk.	','MIDI'),
        ('Mitra Keluarga Karyasehat Tbk.	','MIKA'),
        ('Sanurhasta Mitra Tbk.	','MINA	'),
        ('Mitra International Resources	','MIRA'),
        ('Mitra Investindo Tbk.	','MITI'),
        ('Mitra Komunikasi Nusantara Tbk	','MKNT'),
        ('Metropolitan Kentjana Tbk.	','MKPI'),
        ('Multi Bintang Indonesia Tbk.	','MLBI'),
        ('Mulia Industrindo Tbk	','MLIA'),
        ('Multipolar Tbk.	','MLPL'),
        ('Multipolar Technology Tbk.	','MLPT'),
        ('Mega Manunggal Property Tbk.	','MMLP'),
        ('Media Nusantara Citra Tbk.	','MNCN'),
        ('Madusari Murni Indah Tbk.	','MOLI'),
        ('Mitra Pinasthika Mustika Tbk.	','MPMX'),
        ('Megapower Makmur Tbk.	','MPOW'),
        ('Matahari Putra Prima Tbk.	','MPPA'),
        ('Maha Properti Indonesia Tbk.	','MPRO'),
        ('Mustika Ratu Tbk.	','MRAT'),
        ('Maskapai Reasuransi Indonesia	','MREI'),
        ('MNC Studios International Tbk.	','MSIN'),
        ('MNC Sky Vision Tbk.	','MSKY'),
        ('Metrodata Electronics Tbk.	','MTDL'),
        ('Capitalinc Investment Tbk.	','MTFN'),
        ('Metropolitan Land Tbk.	','MTLA'),
        ('Meta Epsi Tbk.	','MTPS'),
        ('Mitra Pemuda Tbk.	','MTRA'),
        ('Metro Realty Tbk.	','MTSM'),
        ('Malacca Trust Wuwungan Insuran	','MTWI'),
        ('Samindo Resources Tbk.	','MYOH'),
        ('Mayora Indah Tbk.	','MYOR'),
        ('Hanson International Tbk.	','MYRX'),
        ('Asia Pacific Investama Tbk.	','MYTX'),
        ('Andalan Perkasa Abadi Tbk.	','NASA'),
        ('Surya Permata Andalan Tbk.	','NATO'),
        ('Pelayaran Nelly Dwi Putri Tbk.	','NELY'),
        ('NFC Indonesia Tbk.	','NFCX'),
        ('Charnic Capital Tbk.	','NICK'),
        ('PAM Mineral Tbk.	','NICL'),
        ('Pelat Timah Nusantara Tbk.	','NIKL'),
        ('Bank OCBC NISP Tbk.	','NIPS'),
        ('City Retail Developments Tbk.	','NIRO'),
        ('Asia Pacific Investama Tbk.	','NISP'),
        ('Bank Nationalnobu Tbk.	','NOBU'),
        ('Nusa Palapa Gemilang Tbk.	','NPGF'),
        ('Nusa Raya Cipta Tbk.	','NRCA'),
        ('Sinergi Megah Internusa Tbk.	','NUSA'),
        ('Nusantara Almazia Tbk.	','NZIA'),
        ('Protech Mitra Perkasa Tbk.	','OASA'),
        ('Onix Capital Tbk.	','OCAP'),
        ('Indo Oil Perkasa Tbk.	','OILS'),
        ('Ancora Indonesia Resources Tbk	','OKAS'),
        ('Indonesia Prima Property Tbk	','OMRE'),
        ('Optima Prima Metal Sinergi Tbk	','OPMS'),
        ('Minna Padi Investama Sekuritas	','PADI'),
        ('Provident Agro Tbk.	','PALM'),
        ('Bima Sakti Pertiwi Tbk.	','PAMG'),
        ('Pratama Abadi Nusa Industri Tb	','PANI'),
        ('Panorama Sentrawisata Tbk.	','PANR'),
        ('Panin Sekuritas Tbk.	','PANS'),
        ('Panca Budi Idaman Tbk.	','PBID'),
        ('Pan Brothers Tbk.	','PBRX'),
        ('Paramita Bangun Sarana Tbk.	','PBSA'),
        ('Prima Cakrawala Abadi Tbk.	','PCAR'),
        ('Destinasi Tirta Nusantara Tbk	','PDES'),
        ('Panca Global Kapital Tbk.	','PEGE'),
        ('Phapros Tbk.	','PEHA'),
        ('Perusahaan Gas Negara Tbk.	','PGAS'),
        ('Tourindo Guide Indonesia Tbk.	','PGJO'),
        ('Pembangunan Graha Lestari Inda	','PGLI'),
        ('Pradiksi Gunatama Tbk.	','PGUN'),
        ('Pelangi Indah Canindo Tbk	','PICO'),
        ('Pembangunan Jaya Ancol Tbk.	','PJAA'),
        ('Perdana Karya Perkasa Tbk	','PKPK'),
        ('Planet Properindo Jaya Tbk.	','PLAN'),
        ('Polaris Investama Tbk	','PLAS'),
        ('Plaza Indonesia Realty Tbk.	','PLIN'),
        ('Putra Mandiri Jembar Tbk.	','PMJS'),
        ('Panca Mitra Multiperdana Tbk.	','PMMP'),
        ('Bank Pan Indonesia Tbk	','PNBN'),
        ('Bank Panin Dubai Syariah Tbk.	','PNBS'),
        ('Pinago Utama Tbk.	','PNGO'),
        ('Paninvest Tbk.	','PNIN'),
        ('Panin Financial Tbk.	','PNLF'),
        ('Pudjiadi & Sons Tbk.	','PNSE'),
        ('Pool Advista Finance Tbk.	','POLA'),
        ('Pollux Investasi Internasional	','POLI'),
        ('Pollux Properti Indonesia Tbk.	','POLL'),
        ('Golden Flower Tbk.	','POLU'),
        ('Asia Pacific Fibers Tbk	','POLY'),
        ('Pool Advista Indonesia Tbk.	','POOL'),
        ('Nusantara Pelabuhan Handal Tbk	','PORT'),
        ('Bliss Properti Indonesia Tbk.	','POSA'),
        ('Cikarang Listrindo Tbk.	','POWR'),
        ('Prima Globalindo Logistik Tbk.	','PPGL'),
        ('PP Presisi Tbk.	','PPRE'),
        ('PP Properti Tbk.	','PPRO'),
        ('Prima Alloy Steel Universal Tb	','PRAS'),
        ('Prodia Widyahusada Tbk.	','PRDA'),
        ('Royal Prima Tbk.	','PRIM'),
        ('J Resources Asia Pasifik Tbk.	','PSAB'),
        ('Prasidha Aneka Niaga Tbk	','PSDN'),
        ('Palma Serasih Tbk.	','PSGO'),
        ('Red Planet Indonesia Tbk.	','PSKT'),
        ('Pelita Samudera Shipping Tbk.	','PSSI'),
        ('Bukit Asam Tbk.	','PTBA'),
        ('Djasa Ubersakti Tbk.	','PTDU'),
        ('Indo Straits Tbk.	','PTIS'),
        ('PP (Persero) Tbk.	','PTPP'),
        ('Pratama Widya Tbk.	','PTPW'),
        ('Petrosea Tbk.	','PTRO'),
        ('Sat Nusapersada Tbk	','PTSN'),
        ('Pioneerindo Gourmet Internatio	','PTSP'),
        ('Pudjiadi Prestige Tbk.	','PUDP'),
        ('Putra Rajawali Kencana Tbk.	','PURA'),
        ('Trinitan Metals and Minerals T	','PURE'),
        ('Puri Global Sukses Tbk.	','PURI'),
        ('Pakuwon Jati Tbk.	','PWON'),
        ('Pyridam Farma Tbk	','PYFA'),
        ('Sarimelati Kencana Tbk.	','PZZA'),
        ('Rukun Raharja Tbk.	','RAJA'),
        ('Ramayana Lestari Sentosa Tbk.	','RALS'),
        ('Supra Boga Lestari Tbk.	','RANC'),
        ('Ristia Bintang Mahkotasejati T	','RBMS'),
        ('Roda Vivatex Tbk	','RDTX'),
        ('Repower Asia Indonesia Tbk.	','REAL'),
        ('Reliance Sekuritas Indonesia T	','RELI'),
        ('Ricky Putra Globalindo Tbk	','RICY'),
        ('Rig Tenders Indonesia Tbk.	','RIGS'),
        ('Rimo International Lestari Tbk	','RIMO'),
        ('Jaya Sukses Makmur Sentosa Tbk	','RISE'),
        ('Bentoel Internasional Investam	','RMBA'),
        ('Rockfields Properti Indonesia	','ROCK'),
        ('Pikko Land Development Tbk.	','RODA'),
        ('Aesler Grup Internasional Tbk.	','RONY'),
        ('Nippon Indosari Corpindo Tbk.	','ROTI'),
        ('Kedoya Adyaraya Tbk.	','RSGK'),
        ('Radiant Utama Interinsco Tbk.	','RUIS'),
        ('Global Sukses Solusi Tbk.	','RUNS'),
        ('Steady Safe Tbk	','SAFE'),
        ('Sarana Meditama Metropolitan T	','SAME'),
        ('Saraswanti Anugerah Makmur Tbk	','SAMF'),
        ('Satria Antaran Prima Tbk.	','SAPX'),
        ('Kota Satu Properti Tbk.	','SATU'),
        ('Sejahtera Bintang Abadi Textil	','SBAT'),
        ;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickers');
    }
}
