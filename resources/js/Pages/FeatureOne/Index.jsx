import Feature from "@/Components/Feature";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { useForm } from "@inertiajs/react";

export default function Index({ feature, answer }) {
    const { data, setData, post, reset, errors, processing } = useForm({
        numberOne: '',
        numberTwo: '',
    });

    const submit = (event) => {
        event.preventDefault();

        post(route('featureOne.calculate'), {
            onSuccess() {
                reset();
            }
        })
    }

    return (
        <Feature feature={feature} answer={answer}>
            <form onSubmit={submit} className="p-8 grid grid-cols-2 gap-3">
                <div>
                    <InputLabel htmlFor="numberOne" value="Number One" />
                    <TextInput
                        id="numberOne"
                        type="text"
                        name="numberOne"
                        value={data.numberOne}
                        className="mt-1 block w-full"
                        onChange={event => setData('numberOne', event.target.value)}
                    />
                    <InputError message={errors.numberOne} className="mt-2" />
                </div>

                <div>
                    <InputLabel htmlFor="numberTwo" value="Number Two" />
                    <TextInput
                        id="numberTwo"
                        type="text"
                        name="numberTwo"
                        value={data.numberTwo}
                        className="mt-1 block w-full"
                        onChange={event => setData('numberTwo', event.target.value)}
                    />
                    <InputError message={errors.numberTwo} className="mt-2" />
                </div>
                <div className="flex items-center justify-end mt-4 col-span-2">
                    <PrimaryButton className="ms-4" disabled={processing}>
                        Calculate
                    </PrimaryButton>
                </div>
            </form>
        </Feature>
    );

}
