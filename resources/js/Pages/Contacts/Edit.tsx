import React from 'react';
import { Head } from '@inertiajs/react';
import { Link, usePage, useForm, router } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import DeleteButton from '@/Components/Button/DeleteButton';
import LoadingButton from '@/Components/Button/LoadingButton';
import TextInput from '@/Components/Form/TextInput';
import SelectInput from '@/Components/Form/SelectInput';
import TrashedMessage from '@/Components/Messages/TrashedMessage';
import { Contact, Customer } from '@/types';
import FieldGroup from '@/Components/Form/FieldGroup';

const Edit = () => {
  const { contact, customers } = usePage<{
    contact: Contact;
    customers: Customer[];
  }>().props;

  const { data, setData, errors, put, processing } = useForm({
    name: contact.name || '',
    email: contact.email || '',
    phone: contact.phone || '',
    customer_id: contact.customer_id || '',
  });

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    put(route('contacts.update', contact.id));
  }

  function destroy() {
    if (confirm('Are you sure you want to delete this contact?')) {
      router.delete(route('contacts.destroy', contact.id));
    }
  }

  function restore() {
    if (confirm('Are you sure you want to restore this contact?')) {
      router.put(route('contacts.restore', contact.id));
    }
  }

  return (
    <div>
      <Head title={`${data.name}`} />
      <h1 className="mb-8 text-3xl font-bold">
        <Link
          href={route('contacts.index')}
          className="text-indigo-600 hover:text-indigo-700"
        >
          Contacts
        </Link>
        <span className="mx-2 font-medium text-indigo-600">/</span>
        {data.name}
      </h1>
      {contact.deleted_at && (
        <TrashedMessage
          message="This contact has been deleted."
          onRestore={restore}
        />
      )}
      <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
        <form onSubmit={handleSubmit}>
          <div className="grid gap-8 p-8 lg:grid-cols-2">
            <FieldGroup
              label="Name"
              name="name"
              error={errors.name}
            >
              <TextInput
                name="name"
                error={errors.name}
                value={data.name}
                onChange={e => setData('name', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup
              label="Customer"
              name="customer_id"
              error={errors.customer_id}
            >
              <SelectInput
                name="customer_id"
                error={errors.customer_id}
                value={data.customer_id}
                onChange={e => setData('customer_id', e.target.value)}
                options={[
                  {
                    value: '',
                    label: ''
                  },
                  ...customers.map(org => ({
                    value: String(org.id),
                    label: org.name
                  }))
                ]}
              />
            </FieldGroup>

            <FieldGroup label="Email" name="email" error={errors.email}>
              <TextInput
                name="email"
                type="email"
                error={errors.email}
                value={data.email}
                onChange={e => setData('email', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Phone" name="phone" error={errors.phone}>
              <TextInput
                name="phone"
                error={errors.phone}
                value={data.phone}
                onChange={e => setData('phone', e.target.value)}
              />
            </FieldGroup>

          </div>
          <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
            {!contact.deleted_at && (
              <DeleteButton onDelete={destroy}>Delete Contact</DeleteButton>
            )}
            <LoadingButton
              loading={processing}
              type="submit"
              className="ml-auto btn-indigo"
            >
              Update Contact
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

/**
 * Persistent Layout (Inertia.js)
 *
 * [Learn more](https://inertiajs.com/pages#persistent-layouts)
 */
Edit.layout = (page: React.ReactNode) => <MainLayout children={page} />;

export default Edit;
