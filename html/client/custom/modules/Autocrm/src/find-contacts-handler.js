define(['action-handler'], function (ActionHandler) {

  return ActionHandler.extend({

    actionFindContacts: function (model) {

      let email = this.view.model.get('emailAddress');

      if (!email) {
        alert('Lead má prázdný email.');
        return;
      }

      // Call backend
      Espo.Ajax.getRequest('FindContacts', { email: email })
        .then(response => {

          if (!response || !response.list || response.list.length === 0) {
            alert('Nenalezeny žádné kontakty.');
            return;
          }

          // List names
          let names = response.list.map(x => x.firstName + ' ' + x.lastName).join('\n');
          alert('Nalezení kontakty:\n\n' + names);
        })
        .catch(e => {
          console.error(e);
          alert('Chyba při načítání.');
        });
    }
  });
});
