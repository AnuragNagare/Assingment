#To redirect the user to a page where all the submitted forms are displayed
#Define a Django view that retrieves all the submitted forms from the database and renders a template to display them.

from django.shortcuts import render
from .models import MyModel

def form_list(request):
    forms = MyModel.objects.all()
    return render(request, 'form_list.html', {'forms': forms})

#we retrieve all the instances of MyModel from the database using the all() method, and pass them to the form_list.html template.

#Define a URL pattern that maps to the form_list view.

from django.urls import path
from .views import my_view, form_list

urlpatterns = [
    path('', my_view, name='my_view'),
    path('forms/', form_list, name='form_list'),
]

#we define two URL patterns: one for the my_view view that displays the form, and one for the form_list view that displays all the submitted forms.

#In the my_view view, redirect the user to the form_list view after the form has been submitted and saved.

from django.shortcuts import render, redirect
from .forms import MyForm

def my_view(request):
    if request.method == 'POST':
        form = MyForm(request.POST)
        if form.is_valid():
            form.save()

            # Send email to form submitter

            return redirect('form_list')
    else:
        form = MyForm()

    return render(request, 'my_form.html', {'form': form})

# we use the redirect function from django.shortcuts to redirect the user to the form_list view after the form has been saved.