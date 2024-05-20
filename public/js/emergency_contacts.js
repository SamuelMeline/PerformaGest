const addEmergencyContactToCollection = (e) => {
	const collectionHolder = document.querySelector(
		e.currentTarget.dataset.collection
	);
	const item = document.createElement("div");
	item.className = "emergency-contact mt-3 bg-warning p-3";

	item.innerHTML = collectionHolder.dataset.prototype.replace(
		/__name__/g,
		collectionHolder.dataset.index
	);

	// Ajoute un bouton de suppression pour supprimer le contact d'urgence
	let btnSupprimer = document.createElement("button");
	btnSupprimer.className = "btn btn-danger btn-supprimer";
	btnSupprimer.type = "button";
	btnSupprimer.innerHTML = "Supprimer";
	item.appendChild(btnSupprimer);

	collectionHolder.appendChild(item);
	collectionHolder.dataset.index++;

	// Ajoute un gestionnaire d'événements de clic pour supprimer le contact d'urgence
	btnSupprimer.addEventListener("click", (e) => {
		e.currentTarget.parentElement.remove();
	});
}

	// Ajoute un gestionnaire d'événements de clic pour ajouter un contact d'urgence à la collection
	document.querySelectorAll(".btn-ajouter").forEach((btn) =>
			btn.addEventListener("click", addEmergencyContactToCollection));