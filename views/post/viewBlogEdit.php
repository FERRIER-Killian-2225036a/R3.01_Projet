<link rel="stylesheet" href="/common_styles/post.css">
<link rel="stylesheet" href="/common_styles/simple-tags.css" >
<main class="container p-5">
    <div class="p-3">
        <div id="title">
            <h2>Edition nouveau blog</h2>
            <button class="btn btn-outline-danger" onclick="window.location.href='https://cyphub.tech/Menu/BlogFeed';">Quitter</button>
        </div>

        <!-- Titre -->
        <label class="bg-body-tertiary round background">
            <input type="text" class="form-control custom-input round inputBackground input" placeholder="Entrez votre titre">
        </label>

        <!-- Catégories -->
        <label class="bg-body-tertiary round background" id="categoriesLabel">
            <input type="text" class="form-control custom-input round inputBackground input" id="categoriesInput" placeholder="Entrez vos catégories">
            <p id="categoriesOutput">Vos catégories s'afficherons ici</p>
        </label>

        <div id="place" class="form-control select" data-mutable>
            <input id="place_input" type="text" data-bs-toggle="dropdown" />
            <div class="dropdown-menu"></div>
            <select name="place" multiple hidden>
                <option value="01">ADANA</option>
                <option value="02">ADIYAMAN</option>
                <option value="03">AFYONKARAHİSAR</option>
                <option value="04">AĞRI</option>
                <option value="05">AMASYA</option>
                <option value="06">ANKARA</option>
                <option value="07">ANTALYA</option>
                <option value="08">ARTVİN</option>
                <option value="09">AYDIN</option>
                <option value="10">BALIKESİR</option>
                <option value="11">BİLECİK</option>
                <option value="12">BİNGÖL</option>
                <option value="13">BİTLİS</option>
                <option value="14">BOLU</option>
                <option value="15">BURDUR</option>
                <option value="16">BURSA</option>
                <option value="17">ÇANAKKALE</option>
                <option value="18">ÇANKIRI</option>
                <option value="19">ÇORUM</option>
                <option value="20">DENİZLİ</option>
                <option value="21">DİYARBAKIR</option>
                <option value="22">EDİRNE</option>
                <option value="23">ELAZIĞ</option>
                <option value="24">ERZİNCAN</option>
                <option value="25">ERZURUM</option>
                <option value="26">ESKİŞEHİR</option>
                <option value="27">GAZİANTEP</option>
                <option value="28">GİRESUN</option>
                <option value="29">GÜMÜŞHANE</option>
                <option value="30">HAKKARİ</option>
                <option value="31">HATAY</option>
                <option value="32">ISPARTA</option>
                <option value="33">MERSİN</option>
                <option value="34">İSTANBUL</option>
                <option value="35">İZMİR</option>
                <option value="36">KARS</option>
                <option value="37">KASTAMONU</option>
                <option value="38">KAYSERİ</option>
                <option value="39">KIRKLARELİ</option>
                <option value="40">KIRŞEHİR</option>
                <option value="42">KONYA</option>
                <option value="43">KÜTAHYA</option>
                <option value="44">MALATYA</option>
                <option value="45">MANİSA</option>
                <option value="46">KAHRAMANMARAŞ</option>
                <option value="47">MARDİN</option>
                <option value="48">MUĞLA</option>
                <option value="49">MUŞ</option>
                <option value="50">NEVŞEHİR</option>
                <option value="51">NİĞDE</option>
                <option value="52">ORDU</option>
                <option value="53">RİZE</option>
                <option value="54">SAKARYA</option>
                <option value="55">SAMSUN</option>
                <option value="56">SİİRT</option>
                <option value="57">SİNOP</option>
                <option value="58">SİVAS</option>
                <option value="59">TEKİRDAĞ</option>
                <option value="60">TOKAT</option>
                <option value="61">TRABZON</option>
                <option value="62">TUNCELİ</option>
                <option value="63">ŞANLIURFA</option>
                <option value="64">UŞAK</option>
                <option value="65">VAN</option>
                <option value="66">YOZGAT</option>
                <option value="67">ZONGULDAK</option>
                <option value="68">AKSARAY</option>
                <option value="69">BAYBURT</option>
                <option value="70">KARAMAN</option>
                <option value="71">KIRIKKALE</option>
                <option value="72">BATMAN</option>
                <option value="73">ŞIRNAK</option>
                <option value="74">BARTIN</option>
                <option value="75">ARDAHAN</option>
                <option value="76">IĞDIR</option>
                <option value="77">YALOVA</option>
                <option value="78">KARABÜK</option>
                <option value="79">KİLİS</option>
                <option value="80">OSMANİYE</option>
                <option value="81">DÜZCE</option>
            </select>
        </div>

        <!-- Input d'image -->
        <form action="/Settings/ManageAccount" method="POST" enctype="multipart/form-data" class="background round">
            <label for="file" class="btn mr-2 round" id="chooseFileLabel">
                <input id="file" type="file" name="ProfilePicture" accept=".jpg, .jpeg, .png, .gif" style="display: none;">
                <p>Entrez votre miniature</p>
                <img src="../../media/public_assets/imageTest.jpeg" width="300" height="200" alt="">
            </label>
        </form>

        <!-- Texte -->
        <label class="bg-body-tertiary round background textInput">
            <textarea class="form-control custom-input round inputBackground input" placeholder="Entrez le contenue"></textarea>
        </label>

        <!-- Bouton publier -->
        <span id="publishButtonContainer">
            <button class="btn btn-outline" id="publishButton">Publier</button>
        </span>
    </div>
    <script src="../../common_scripts/blog.js"></script>
    <script src="../../common_scripts/simple-tags.js"></script>

</main>

