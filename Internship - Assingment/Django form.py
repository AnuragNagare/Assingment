#django form for date of the birth and name and email phone number

from django import forms

class ContactForm(forms.Form):
    name = forms.CharField(max_length=50)
    email = forms.EmailField()
    phone = forms.CharField(max_length=20)
    date_of_birth = forms.DateField()

#This form includes four fields, each with a different type of input:

#name: a text input for the user's name, with a maximum length of 50 characters.
#email: a text input for the user's email address, which will be validated to ensure it is a properly formatted email address.
#phone: a text input for the user's phone number, with a maximum length of 20 characters.
#date_of_birth: a date input for the user's date of birth.
#You can use this form in a Django view to collect and process user data. For example:

from django.shortcuts import render
from .forms import ContactForm

def contact(request):
    if request.method == 'POST':
        form = ContactForm(request.POST)
        if form.is_valid():
            # Do something with the form data, such as saving it to a database
            name = form.cleaned_data['name']
            email = form.cleaned_data['email']
            phone = form.cleaned_data['phone']
            date_of_birth = form.cleaned_data['date_of_birth']
            # Return a success message to the user
            return render(request, 'success.html')
    else:
        form = ContactForm()
    return render(request, 'contact.html', {'form': form})

#In this example, the view checks if the form has been submitted via a POST request, and if it has, it validates the form using form.is_valid(). If the form is valid, the view can access the cleaned data using form.cleaned_data, which returns a dictionary of the form field values. The view can then process the form data as needed (such as saving it to a database), and return a success message to the user. If the form has not been submitted yet (i.e. it's a GET request), the view will simply render the form template with an empty form object.