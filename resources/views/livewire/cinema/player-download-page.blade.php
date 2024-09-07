<div>
    <div class="min-h-screen flex flex-col flex-wrap justify-center content-center gap-8" x-data="{
        eulaAccepted: @entangle('eula')
    }">
        <div class="card lg:max-w-lg w-full bg-base-100 shadow-xl" id="step-1">
            <div class="card-body">
                <h2 class="card-title">Download cinecode Player Lite</h2>
                <p class="mb-11">Please select a Platform.</p>

                <div class="flex flex-row gap-2 justify-center">
                    <div class="card bg-transparent text-neutral-content w-28 border border-neutral-content cursor-pointer"
                        wire:click="downloadPlayer('windows')">
                        <div class="card-body items-center text-center !py-3 !px-0">
                            <div>
                                <svg height="35px" width="35px" version="1.1" id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 452.986 452.986" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path style="fill:#010002;" d="M165.265,53.107L21.689,81.753v132.531l143.575-2.416V53.107 M431.297,245.583l-233.18-3.991
   v164.822l233.18,46.571V245.583 M165.265,241.097l-143.575-2.438v132.509l143.575,28.668V241.097 M431.297,0l-233.18,46.528
   v164.822l233.18-3.969V0" />
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                    </g>
                                </svg>
                            </div>

                            <h5 class="text-neutral text-sm">Windows</h5>
                        </div>
                    </div>
                    <div class="card bg-transparent text-neutral-content w-28 border border-neutral-content cursor-pointer"
                        wire:click="downloadPlayer('mac_sil')">
                        <div class="card-body items-center text-center !py-3 !px-0">
                            <div>

                                <svg class="svg-icon"
                                    style="width: 35px; height: 35px;vertical-align: middle;overflow: hidden;"
                                    viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M849.124134 704.896288c-1.040702 3.157923-17.300015 59.872622-57.250912 118.190843-34.577516 50.305733-70.331835 101.018741-126.801964 101.909018-55.532781 0.976234-73.303516-33.134655-136.707568-33.134655-63.323211 0-83.23061 32.244378-135.712915 34.110889-54.254671 2.220574-96.003518-54.951543-130.712017-105.011682-70.934562-102.549607-125.552507-290.600541-52.30118-416.625816 36.040844-63.055105 100.821243-103.135962 171.364903-104.230899 53.160757-1.004887 103.739712 36.012192 136.028093 36.012192 33.171494 0 94.357018-44.791136 158.90615-38.089503 27.02654 1.151219 102.622262 11.298324 151.328567 81.891102-3.832282 2.607384-90.452081 53.724599-89.487104 157.76107C739.079832 663.275355 847.952448 704.467523 849.124134 704.896288M633.69669 230.749408c29.107945-35.506678 48.235584-84.314291 43.202964-132.785236-41.560558 1.630127-92.196819 27.600615-122.291231 62.896492-26.609031 30.794353-50.062186 80.362282-43.521213 128.270409C557.264926 291.935955 604.745311 264.949324 633.69669 230.749408" />
                                </svg>
                            </div>

                            <h5 class="text-neutral text-sm">macOS Silicon</h5>
                        </div>
                    </div>
                    <div class="card bg-transparent text-neutral-content w-28 border border-neutral-content cursor-pointer"
                        wire:click="downloadPlayer('mac_intel')">
                        <div class="card-body items-center text-center !py-3 !px-0">
                            <div>

                                <svg class="svg-icon"
                                    style="width: 35px; height: 35px;vertical-align: middle;overflow: hidden;"
                                    viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M849.124134 704.896288c-1.040702 3.157923-17.300015 59.872622-57.250912 118.190843-34.577516 50.305733-70.331835 101.018741-126.801964 101.909018-55.532781 0.976234-73.303516-33.134655-136.707568-33.134655-63.323211 0-83.23061 32.244378-135.712915 34.110889-54.254671 2.220574-96.003518-54.951543-130.712017-105.011682-70.934562-102.549607-125.552507-290.600541-52.30118-416.625816 36.040844-63.055105 100.821243-103.135962 171.364903-104.230899 53.160757-1.004887 103.739712 36.012192 136.028093 36.012192 33.171494 0 94.357018-44.791136 158.90615-38.089503 27.02654 1.151219 102.622262 11.298324 151.328567 81.891102-3.832282 2.607384-90.452081 53.724599-89.487104 157.76107C739.079832 663.275355 847.952448 704.467523 849.124134 704.896288M633.69669 230.749408c29.107945-35.506678 48.235584-84.314291 43.202964-132.785236-41.560558 1.630127-92.196819 27.600615-122.291231 62.896492-26.609031 30.794353-50.062186 80.362282-43.521213 128.270409C557.264926 291.935955 604.745311 264.949324 633.69669 230.749408" />
                                </svg>
                            </div>

                            <h5 class="text-neutral text-sm">macOS Intel</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-modal wire:model="downloadModal" persistent>
            <div class="prose ">
                <h2>Endbenutzer-Lizenzvereinbarung (EULA) von <span class="app_name">cinecode Player Lite</span></h2>
                <p>Diese Endbenutzer-Lizenzvereinbarung ("EULA") ist eine rechtliche Vereinbarung zwischen Ihnen und
                    <span class="company_name">cinecode Germany</span>. Der cinecode Player Lite entschlüsselt und
                    spielt verschlüsselte Filme für kommerzielle Nutzung ab.
                </p>
                <p>Diese EULA-Vereinbarung regelt den Erwerb und die Nutzung unserer <span class="app_name">cinecode
                        Player Lite</span>-Software ("Software") direkt von <span class="company_name">cinecode
                        Germany</span> oder indirekt über einen von <span class="company_name">cinecode Germany</span>
                    autorisierten Wiederverkäufer oder Distributor (ein "Reseller"). </p>
                <p>Lesen Sie diese EULA-Vereinbarung bitte sorgfältig durch, bevor Sie den Installationsprozess
                    abschließen und die <span class="app_name">cinecode Player Lite</span>-Software verwenden. Sie
                    gewährt eine Lizenz zur Nutzung der <span class="app_name">cinecode Player Lite</span>-Software und
                    enthält Informationen zu Garantien und Haftungsausschlüssen.</p>
                <p>Wenn Sie sich für eine kostenlose Testversion der <span class="app_name">cinecode Player
                        Lite</span>-Software registrieren, gilt diese EULA-Vereinbarung auch für diese Testversion.
                    Durch Klicken auf "Akzeptieren" oder durch die Installation und/oder Verwendung der <span
                        class="app_name">cinecode Player Lite</span>-Software bestätigen Sie Ihre Akzeptanz der Software
                    und erklären sich damit einverstanden, an die Bedingungen dieser EULA-Vereinbarung gebunden zu sein.
                </p>
                <p>Wenn Sie diese EULA-Vereinbarung im Namen eines Unternehmens oder einer anderen juristischen Person
                    eingehen, erklären Sie, dass Sie die Befugnis haben, diese Entität und ihre Tochtergesellschaften an
                    diese Bedingungen zu binden. Wenn Sie diese Befugnis nicht haben oder wenn Sie den Bedingungen
                    dieser EULA-Vereinbarung nicht zustimmen, installieren oder verwenden Sie die Software nicht, und
                    Sie müssen diese EULA-Vereinbarung nicht akzeptieren.</p>
                <p>Diese EULA-Vereinbarung gilt nur für die Software, die von <span class="company_name">cinecode
                        Germany</span> hiermit geliefert wird, unabhängig davon, ob hierin auf andere Software Bezug
                    genommen oder diese beschrieben wird. Die Bedingungen gelten auch für alle von <span
                        class="company_name">cinecode Germany</span> bereitgestellten Updates, Ergänzungen,
                    internetbasierten Dienste und Supportdienste für die Software, sofern nicht andere Bedingungen mit
                    der Lieferung dieser Artikel einhergehen. In diesem Fall gelten diese Bedingungen.</p>
                <h3>Lizenzgewährung</h3>
                <p><span class="company_name">cinecode Germany</span> gewährt Ihnen hiermit eine persönliche, nicht
                    übertragbare, nicht exklusive Lizenz zur Nutzung der <span class="app_name">cinecode Player
                        Lite</span>-Software auf Ihren Geräten gemäß den Bedingungen dieser EULA-Vereinbarung.</p>
                <p>Sie dürfen die <span class="app_name">cinecode Player Lite</span>-Software (zum Beispiel auf einem
                    PC, Laptop, Mobiltelefon oder Tablet) unter Ihrer Kontrolle laden. Sie sind dafür verantwortlich,
                    sicherzustellen, dass Ihr Gerät die Mindestanforderungen der <span class="app_name">cinecode Player
                        Lite</span>-Software erfüllt.</p>
                <p>Ihnen ist es nicht gestattet:</p>
                <ul>
                    <li>Die Software ganz oder teilweise zu bearbeiten, zu verändern, anzupassen, zu übersetzen oder
                        anderweitig zu ändern, noch die Software ganz oder teilweise mit einer anderen Software zu
                        kombinieren oder in diese einzubeziehen, noch die Software zu dekompilieren, zu disassemblieren
                        oder reverse engineering oder solche Versuche zu unternehmen.</li>
                    <li>Die Software für kommerzielle Zwecke zu reproduzieren, zu kopieren, zu verteilen, zu verkaufen
                        oder anderweitig zu nutzen.</li>
                    <li>Dritten die Nutzung der Software im Namen oder zum Vorteil Dritter zu gestatten.</li>
                    <li>Die Software in einer Weise zu verwenden, die gegen geltendes lokales, nationales oder
                        internationales Recht verstößt.</li>
                    <li>Die Software für jeden Zweck zu verwenden, den <span class="company_name">cinecode
                            Germany</span> als Verstoß gegen diese EULA-Vereinbarung betrachtet.</li>
                </ul>
                <h3>Geistiges Eigentum und Eigentum</h3>
                <p><span class="company_name">cinecode Germany</span> behält zu jeder Zeit das Eigentum an der Software,
                    wie sie von Ihnen ursprünglich heruntergeladen wurde, und allen darauffolgenden Downloads der
                    Software durch Sie. Die Software (und die Urheberrechte und anderen geistigen Eigentumsrechte
                    jeglicher Art an der Software, einschließlich etwaiger Modifikationen) sind und bleiben Eigentum von
                    <span class="company_name">cinecode Germany</span>.
                </p>
                <p><span class="company_name">cinecode Germany</span> behält sich das Recht vor, Lizenzen zur Nutzung
                    der Software an Dritte zu vergeben.</p>
                <h3>Beendigung</h3>
                <p>Diese EULA-Vereinbarung tritt ab dem Datum Ihrer ersten Nutzung der Software in Kraft und bleibt bis
                    zur Beendigung wirksam. Sie können sie jederzeit durch schriftliche Mitteilung an <span
                        class="company_name">cinecode Germany</span> beenden.</p>
                <p>Sie endet auch sofort, wenn Sie gegen eine Bestimmung dieser EULA-Vereinbarung verstoßen. Bei einer
                    solchen Beendigung werden die durch diese EULA-Vereinbarung gewährten Lizenzen sofort beendet, und
                    Sie erklären sich bereit, den Zugriff auf die Software zu beenden. Die Bestimmungen, die aufgrund
                    ihrer Natur fortbestehen, werden jede Beendigung dieser EULA-Vereinbarung überdauern.</p>
                <h3>Geltendes Recht</h3>
                <p>Diese EULA-Vereinbarung und alle Streitigkeiten im Zusammenhang mit dieser EULA-Vereinbarung
                    unterliegen den Gesetzen von <span class="country">Deutschland</span> und werden entsprechend
                    ausgelegt.</p>

                <label class="cursor-pointer label justify-normal">
                    <input type="checkbox" wire:model='eula'
                        class="checkbox [--chkbg:theme(colors.cine-highlight-1)] border-cine-highlight-1" />
                    <span class="label-text ml-3"> Ich akzeptiere die Nutzungsbedingungen.</span>
                </label>
            </div>
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.downloadModal = false" />
                <x-button label="Confirm" class="btn-cine-highlight-1" x-bind:disabled="!eulaAccepted"
                    wire:click='confirmDownloadPlayer()' />
            </x-slot:actions>
        </x-modal>
    </div>
</div>
