export interface ChangePasswordInterface {
    oldPassword: string;
    password: string;
    passwordConfirmation: string
}

export default class ChangePassword implements ChangePasswordInterface {
    oldPassword: string;
    password: string;
    passwordConfirmation: string

    constructor(data?: ChangePasswordInterface|null) {
        this.oldPassword = data?.oldPassword || '';
        this.password = data?.password || '';
        this.passwordConfirmation = data?.passwordConfirmation || '';
    }
}
