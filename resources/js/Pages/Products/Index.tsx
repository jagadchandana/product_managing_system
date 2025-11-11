import React from 'react'
import { Head, Link, useForm, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'

const Index: React.FC = () => {
  const { products, filters } = usePage().props as any
  const items = products?.data || []
  const form = useForm({ search: filters?.search || '' })

  function submit(e: React.FormEvent) {
    e.preventDefault()
    form.get(route('products.index'), { preserveState: true })
  }

  function clear() {
    form.setData('search', '')
    form.get(route('products.index'), { preserveState: true })
  }

  return (
    <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Products</h2>}>
      <Head title="Products" />

      <div className="py-6">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <div className="mb-4">
                <Link href={route('products.create')} className="inline-block rounded bg-indigo-600 px-3 py-1 text-white">Create product</Link>
              </div>

              <form onSubmit={submit} className="mb-4 flex flex-col sm:flex-row gap-2">
                <input
                  type="text"
                  placeholder="Search by name"
                  value={form.data.search}
                  onChange={e => form.setData('search', e.target.value)}
                  className="w-full rounded border-gray-300 px-3 py-2"
                />
                <button type="submit" className="rounded bg-gray-200 px-3">Search</button>
                <button type="button" onClick={clear} className="rounded bg-gray-200 px-3">Clear</button>
              </form>
              <div className="-mx-4 sm:-mx-0">
                <div className="overflow-x-auto">
                  <table className="min-w-full table-auto border-collapse">
                <thead>
                  <tr className="bg-gray-100">
                    <th className="border px-2 py-1 text-left">ID</th>
                    <th className="border px-2 py-1 text-left">Name</th>
                    <th className="border px-2 py-1 text-left">Price</th>
                    <th className="border px-2 py-1 text-left">Stock</th>
                    <th className="border px-2 py-1 text-left">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {items.map((p: any) => (
                    <tr key={p.id} className="odd:bg-white even:bg-gray-50">
                      <td className="border px-2 py-1">{p.id}</td>
                      <td className="border px-2 py-1">{p.name}</td>
                      <td className="border px-2 py-1">{Number(p.price).toFixed(2)}</td>
                      <td className="border px-2 py-1">{p.stock_quantity}</td>
                      <td className="border px-2 py-1 space-x-2">
                        <Link href={route('products.show', p.id)} className="text-indigo-600">View</Link>
                        <Link href={route('products.edit', p.id)} className="text-indigo-600">Edit</Link>
                        <form action={route('products.destroy', p.id)} method="POST" style={{display:'inline'}}>
                          <input type="hidden" name="_method" value="DELETE" />
                          <input type="hidden" name="_token" value={(usePage().props as any).csrf_token} />
                          <button type="submit" className="text-red-600">Delete</button>
                        </form>
                      </td>
                    </tr>
                  ))}
                </tbody>
                  </table>
                </div>
              </div>

              <div className="mt-4">
                {products && (
                  <div className="text-sm text-gray-600">
                    {products.links && products.links.map((link: any, idx: number) => (
                      <span key={idx} dangerouslySetInnerHTML={{__html: link.label}} className="mx-1" />
                    ))}
                  </div>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  )
}

export default Index
