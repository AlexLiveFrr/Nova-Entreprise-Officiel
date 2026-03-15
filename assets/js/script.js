// --- Script global site : menu + formulaires webhook ---
document.addEventListener("DOMContentLoaded", () => {
    initMobileMenu();
    initRecruitmentForm();
    initPartnerForm();
});

function initMobileMenu() {
    const mobileMenu = document.getElementById("mobile-menu");
    const navLinks = document.getElementById("nav-links");

    if (!mobileMenu || !navLinks) return;

    mobileMenu.addEventListener("click", () => {
        navLinks.classList.toggle("active");
        mobileMenu.classList.toggle("open");
    });
}

async function sendWebhook(type, payload) {
    // Live Server (port 5500) ne traite pas le PHP -> webhook-proxy.php ne fonctionne pas.
    if (window.location.port === "5500") {
        throw new Error(
            "Tu es sur Live Server (127.0.0.1:5500). Ouvre le site via WAMP (ex: http://localhost/SiteETS/LTDRS/contact.html)."
        );
    }

    const response = await fetch("api/webhook-proxy.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ type, payload }),
    });

    let data = {};
    try {
        data = await response.json();
    } catch (e) {
        data = {};
    }

    if (!response.ok || !data.success) {
        const statusInfo = response.status ? ` (HTTP ${response.status})` : "";
        throw new Error((data.error || "Impossible d'envoyer le webhook.") + statusInfo);
    }

    return data;
}

function initRecruitmentForm() {
    const form = document.getElementById("discordForm");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = "Envoi en cours...";
        }

        try {
            const role = getValue("role");
            const pseudo = getValue("username");
            const age = getValue("age");
            const steamId = getValue("steam_id") || "Non renseigne";
            const hours = getValue("hours");
            const hardware = getValue("hardware");
            const driveStyles = document.querySelectorAll("#drive_style");
            const style = driveStyles[0] ? driveStyles[0].value : "Non precise";
            const pluginsMods = driveStyles[1] ? driveStyles[1].value : "Non precise";
            const availability = getValue("availability") || "Non precise";
            const motivation = getValue("motivation") || "Aucune motivation redigee.";
            const expLevel = getValue("exp_level");
            const acceptedRules = !!document.getElementById("accept_rules")?.checked;

            const dlcList = Array.from(document.querySelectorAll(".dlc:checked")).map((cb) => cb.value);
            const dlcFinal = formatDiscordList(dlcList);

            const payload = {
                embeds: [
                    {
                        title: "Nouveau dossier de recrutement",
                        description: `Nouvelle candidature pour le poste : ${role}`,
                        color: 13848362,
                        fields: [
                            { name: "Poste", value: role, inline: true },
                            { name: "Niveau", value: expLevel || "Non precise", inline: true },
                            { name: "Pseudo Discord", value: pseudo, inline: true },
                            { name: "Age", value: `${age} ans`, inline: true },
                            { name: "Heures OMSI 2", value: `${hours}h`, inline: true },
                            { name: "Style de conduite", value: style, inline: true },
                            { name: "Plugins / Modifications", value: pluginsMods, inline: true },
                            { name: "Materiel", value: hardware || "Non precise", inline: true },
                            { name: "Steam ID", value: steamId, inline: false },
                            { name: "Disponibilites", value: availability, inline: false },
                            { name: "DLC / Addons", value: dlcFinal, inline: false },
                            { name: "Reglement", value: acceptedRules ? "Accepte" : "Non accepte", inline: true },
                            { name: "Motivation", value: motivation.slice(0, 1000), inline: false },
                        ],
                        footer: { text: "Nova Entreprise Officiel - Recrutement" },
                        timestamp: new Date().toISOString(),
                    },
                ],
            };

            await sendWebhook("recruitment", payload);

            form.innerHTML = `
                <div class="text-center py-10">
                    <div class="text-6xl mb-6">✅</div>
                    <h2 class="text-3xl font-black uppercase italic text-white mb-4">Dossier transmis</h2>
                    <p class="text-gray-300 mb-6 text-lg">Merci ${pseudo}, ta candidature a bien ete envoyee.</p>
                    <a href="index.html" class="text-gray-400 hover:text-white text-xs uppercase tracking-widest transition-colors font-bold">Retour a l'accueil</a>
                </div>
            `;
            window.scrollTo({ top: 0, behavior: "smooth" });
        } catch (error) {
            alert("Erreur lors de l'envoi du dossier : " + error.message);
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = "Transmettre mon dossier";
            }
        }
    });
}

function initPartnerForm() {
    const form = document.getElementById("partnerForm");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = "Envoi en cours...";
        }

        try {
            const vtcName = getValue("vtc_name");
            const memberCount = getValue("member_count");
            const tmpLink = getValue("tmp_link") || "Non renseigne";
            const truckbookLink = getValue("truckbook_link") || "Non renseigne";
            const pickupLink = getValue("pickup_link") || "Non renseigne";
            const discordId = getValue("discord_id");
            const discordInvite = getValue("discord_invite");
            const message = getValue("message");

            const payload = {
                embeds: [
                    {
                        title: "Nouvelle demande de partenariat",
                        color: 5814783,
                        fields: [
                            { name: "Entreprise", value: vtcName, inline: true },
                            { name: "Conducteurs", value: memberCount, inline: true },
                            { name: "Discord (contact)", value: discordId, inline: true },
                            { name: "Invite Discord", value: discordInvite, inline: false },
                            { name: "Lien site / presentation", value: tmpLink, inline: false },
                            { name: "Lien OMSI WebDisk / Forum", value: truckbookLink, inline: false },
                            { name: "Lien reseaux / communaute", value: pickupLink, inline: false },
                            { name: "Projet de partenariat", value: message.slice(0, 1000), inline: false },
                        ],
                        footer: { text: "Nova Entreprise Officiel - Partenariat" },
                        timestamp: new Date().toISOString(),
                    },
                ],
            };

            await sendWebhook("partner", payload);

            form.innerHTML = `
                <div class="text-center py-10">
                    <div class="text-6xl mb-6">✅</div>
                    <h2 class="text-3xl font-black uppercase italic text-white mb-4">Demande envoyee</h2>
                    <p class="text-gray-300 mb-6 text-lg">La demande de ${vtcName} a bien ete transmise a la direction.</p>
                    <a href="partenaires.html" class="text-gray-400 hover:text-white text-xs uppercase tracking-widest transition-colors font-bold">Retour partenaires</a>
                </div>
            `;
            window.scrollTo({ top: 0, behavior: "smooth" });
        } catch (error) {
            alert("Erreur lors de l'envoi du dossier partenaire : " + error.message);
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = "Transmettre le dossier a la direction";
            }
        }
    });
}

function getValue(id) {
    return document.getElementById(id)?.value?.trim() || "";
}

function formatDiscordList(items) {
    if (!items || items.length === 0) return "Aucun DLC coche";

    const lines = items.map((item) => `• ${item}`);
    let output = lines.join("\n");

    // Limite Discord pour un field embed = 1024 caracteres.
    if (output.length > 1000) {
        const kept = [];
        let current = 0;
        for (const line of lines) {
            const next = current + line.length + 1;
            if (next > 960) break;
            kept.push(line);
            current = next;
        }
        const remaining = items.length - kept.length;
        output = kept.join("\n") + `\n… et ${remaining} autre(s)`;
    }

    return output;
}