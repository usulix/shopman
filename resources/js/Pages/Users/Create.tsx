import { Link, useForm } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import LoadingButton from '@/Components/Button/LoadingButton';
import TextInput from '@/Components/Form/TextInput';
import SelectInput from '@/Components/Form/SelectInput';
import FileInput from '@/Components/Form/FileInput';
import FieldGroup from '@/Components/Form/FieldGroup';

const Create = () => {
  const { data, setData, errors, post, processing } = useForm({
    name: '',
    email: '',
    password: '',
    isOwner: '0'
  });

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    post(route('users.store'));
  }

  return (
    <div>
      <div>
        <h1 className="mb-8 text-3xl font-bold">
          <Link
            href={route('users')}
            className="text-indigo-600 hover:text-indigo-700"
          >
            Users
          </Link>
          <span className="font-medium text-indigo-600"> /</span> Create
        </h1>
      </div>
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

            <FieldGroup label="Email" name="email" error={errors.email}>
              <TextInput
                name="email"
                type="email"
                error={errors.email}
                value={data.email}
                onChange={e => setData('email', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup
              label="Password"
              name="password"
              error={errors.password}
            >
              <TextInput
                name="password"
                type="password"
                error={errors.password}
                value={data.password}
                onChange={e => setData('password', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Owner" name="owner" error={errors.owner}>
              <SelectInput
                name="isOwner"
                error={errors.isOwner}
                value={data.isOwner}
                onChange={e => setData('isOwner', e.target.value)}
                options={[
                  { value: '1', label: 'Yes' },
                  { value: '0', label: 'No' }
                ]}
              />
            </FieldGroup>
          </div>
          <div className="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
            <LoadingButton
              loading={processing}
              type="submit"
              className="btn-indigo"
            >
              Create User
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
Create.layout = (page: React.ReactNode) => (
  <MainLayout title="Create User" children={page} />
);

export default Create;
