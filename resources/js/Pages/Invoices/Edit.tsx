import React from 'react';
import { Head } from '@inertiajs/react';
import { Link, usePage, useForm, router } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import DeleteButton from '@/Components/Button/DeleteButton';
import LoadingButton from '@/Components/Button/LoadingButton';
import TextInput from '@/Components/Form/TextInput';
import SelectInput from '@/Components/Form/SelectInput';
import TrashedMessage from '@/Components/Messages/TrashedMessage';
import FieldGroup from '@/Components/Form/FieldGroup';

const Edit = () => {
  const { invoice } = usePage<{
    invoice: Invoice;
  }>().props;

  const { data, setData, errors, put, processing } = useForm({
    number: invoice.number || '',
    status: invoice.status || '',
    task_id: invoice.task_id || '',
    total: invoice.total || ''
  });

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    put(route('invoices.update', invoice.id));
  }

  function destroy() {
    if (confirm('Are you sure you want to delete this invoice?')) {
      router.delete(route('invoices.destroy', part.id));
    }
  }

  function restore() {
    if (confirm('Are you sure you want to restore this invoice?')) {
      router.put(route('invoices.restore', part.id));
    }
  }

  return (
    <div>
      <Head title={`${data.number}`} />
      <h1 className="mb-8 text-3xl font-bold">
        <Link
          href={route('invoices.index')}
          className="text-indigo-600 hover:text-indigo-700"
        >
          Invoice
        </Link>
        <span className="mx-2 font-medium text-indigo-600">/</span>
        {data.number}
      </h1>
      {invoice.deleted_at && (
        <TrashedMessage
          message="This invoice has been deleted."
          onRestore={restore}
        />
      )}
      <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
        <form onSubmit={handleSubmit}>
          <div className="grid gap-8 p-8 lg:grid-cols-2">
            <FieldGroup
              label="Number"
              name="number"
              error={errors.number}
            >
              <TextInput
                disabled
                name="number"
                error={errors.number}
                value={data.number}
                onChange={e => setData('number', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Status" name="status" error={errors.status}>
              <TextInput
                name="status"
                type="status"
                error={errors.status}
                value={data.status}
                onChange={e => setData('status', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Task Id" name="task_id" error={errors.task_id}>
              <TextInput
                disabled
                name="task_id"
                error={errors.task_id}
                value={data.task_id}
                onChange={e => setData('task_id', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Total" name="total" error={errors.total}>
              <TextInput
                disabled
                name="total"
                error={errors.total}
                value={data.total}
                onChange={e => setData('total', e.target.value)}
              />
            </FieldGroup>

          </div>
          <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
            {!invoice.deleted_at && (
              <DeleteButton onDelete={destroy}>Delete Invoice</DeleteButton>
            )}
            <LoadingButton
              loading={processing}
              type="submit"
              className="ml-auto btn-indigo"
            >
              Update Invoice
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
